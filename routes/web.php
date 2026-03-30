<?php

use App\Http\Controllers\AdminCustomerRequestController;
use App\Http\Controllers\AdminDonationController;
use App\Http\Controllers\AdminRequestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BeneficiaryRequestController;
use App\Http\Controllers\CustomerShopController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\TaskController;
use App\Models\CustomerRequestDonation;
use App\Models\Donation;
use App\Models\Inventory;
use App\Models\Task;
use App\Models\User;
use App\Notifications\SystemAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }

    $publicStats = [
        'donors' => 0,
        'volunteers' => 0,
        'donations' => 0,
        'inventory_stock' => 0,
    ];

    try {
        $publicStats = [
            'donors' => User::where('role', 'donor')->count(),
            'volunteers' => User::where('role', 'volunteer')->count(),
            'donations' => Donation::count(),
            'inventory_stock' => Inventory::sum('available_quantity'),
        ];
    } catch (\Throwable $e) {
        // Keep landing page accessible even before migrations are complete.
    }

    return view('welcome', compact('publicStats'));
});

Route::post('/admin/customer-requests/{customerRequest}/assign', [\App\Http\Controllers\AdminCustomerRequestController::class, 'assignVolunteer'])
    ->middleware(['auth', 'role:admin']);

// CUSTOMER
Route::get('/customer/products', [CustomerShopController::class, 'products'])->middleware(['auth', 'role:customer']);
Route::post('/customer/requests', [CustomerShopController::class, 'createRequest'])->middleware(['auth', 'role:customer']);
Route::get('/customer/requests', [CustomerShopController::class, 'myRequests'])->middleware(['auth', 'role:customer']);

// ADMIN
Route::get('/admin/customer-requests', [AdminCustomerRequestController::class, 'index'])->middleware(['auth', 'role:admin']);
Route::post('/admin/customer-requests/{customerRequest}/approve', [AdminCustomerRequestController::class, 'approve'])->middleware(['auth', 'role:admin']);
Route::post('/admin/customer-requests/{customerRequest}/reject', [AdminCustomerRequestController::class, 'reject'])->middleware(['auth', 'role:admin']);
Route::post('/admin/customer-requests/{customerRequest}/donor-permission', [AdminCustomerRequestController::class, 'setDonorDonationPermission'])->middleware(['auth', 'role:admin']);
Route::post('/admin/customer-requests/{customerRequest}/donations/{donation}/status', [AdminCustomerRequestController::class, 'updateDonationStatus'])->middleware(['auth', 'role:admin']);

// DONOR + VOLUNTEER can VIEW approved only (simple pages later)
Route::get('/donor/customer-requests', function () {
    abort_unless(auth()->user()->role === 'donor', 403);
    $requests = \App\Models\CustomerRequest::with([
        'customer',
        'items.inventory.item',
        'donations' => function ($q) {
            $q->where('donor_id', auth()->id());
        },
    ])
        ->withCount('donations')
        ->where('status', 'Approved')->latest()->get();

    return view('donor.customer_requests', compact('requests'));
})->middleware(['auth', 'role:donor']);

Route::post('/donor/customer-requests/{customerRequest}/donate', function (Request $request, \App\Models\CustomerRequest $customerRequest) {
    abort_unless(auth()->user()->role === 'donor', 403);

    if ($customerRequest->status !== 'Approved') {
        return back()->with('error', 'You can donate only to approved customer requests.');
    }

    if (! $customerRequest->donor_donation_allowed) {
        return back()->with('error', 'Admin has not enabled donor donations for this request yet.');
    }

    $request->validate([
        'note' => 'nullable|string|max:1000',
    ]);

    $exists = CustomerRequestDonation::where('customer_request_id', $customerRequest->id)
        ->where('donor_id', auth()->id())
        ->exists();

    if ($exists) {
        return back()->with('error', 'You already donated to this request.');
    }

    CustomerRequestDonation::create([
        'customer_request_id' => $customerRequest->id,
        'donor_id' => auth()->id(),
        'note' => $request->note,
        'status' => 'Pledged',
    ]);

    $customerRequest->customer?->notify(new SystemAlert(
        'New Donor Support',
        "A donor pledged support for your request #{$customerRequest->id}.",
        '/customer/requests'
    ));

    User::where('role', 'admin')->get()->each(function ($admin) use ($customerRequest) {
        $admin->notify(new SystemAlert(
            'New Customer Request Donation',
            "A donor pledged support for customer request #{$customerRequest->id}.",
            '/admin/customer-requests'
        ));
    });

    return back()->with('success', 'Donation to customer request submitted successfully.');
})->middleware(['auth', 'role:donor']);

Route::get('/volunteer/customer-requests', function () {
    abort_unless(auth()->user()->role === 'volunteer', 403);
    $requests = \App\Models\CustomerRequest::with('customer', 'items.inventory.item')
        ->withCount('donations')
        ->where('status', 'Approved')->latest()->get();

    return view('volunteer.customer_requests', compact('requests'));
})->middleware(['auth', 'role:volunteer']);

// customer
Route::get('/customer/dashboard', function () {
    $uid = auth()->id();

    $stats = [
        'my_requests' => \App\Models\CustomerRequest::where('customer_id', $uid)->count(),
        'pending_requests' => \App\Models\CustomerRequest::where('customer_id', $uid)->where('status', 'Pending')->count(),
        'approved_requests' => \App\Models\CustomerRequest::where('customer_id', $uid)->where('status', 'Approved')->count(),
        'rejected_requests' => \App\Models\CustomerRequest::where('customer_id', $uid)->where('status', 'Rejected')->count(),
    ];

    return view('dashboards.customer', compact('stats'));
})->middleware(['auth', 'role:customer']);

Route::get('/admin/requests', [AdminRequestController::class, 'index'])->middleware(['auth', 'role:admin']);
Route::post('/admin/requests/{clothingRequest}/approve', [AdminRequestController::class, 'approveAndAllocate'])->middleware(['auth', 'role:admin']);
Route::post('/admin/requests/{clothingRequest}/assign', [AdminRequestController::class, 'assignVolunteer'])->middleware(['auth', 'role:admin']);

Route::get('/admin/donations', [AdminDonationController::class, 'index'])->middleware(['auth', 'role:admin']);
Route::post('/admin/donations/{donation}/assign', [AdminDonationController::class, 'assignVolunteer'])->middleware(['auth', 'role:admin']);
Route::post('/admin/donations/{donation}/status', [AdminDonationController::class, 'updateStatus'])->middleware(['auth', 'role:admin']);

Route::get('/admin/beneficiaries', function () {
    return view('admin.beneficiaries');
})->middleware(['auth', 'role:admin']);

// donations
Route::get('/donations', [DonationController::class, 'index'])->middleware(['auth', 'role:donor']);
Route::get('/donations/create', [DonationController::class, 'create'])->middleware(['auth', 'role:donor']);
Route::post('/donations', [DonationController::class, 'store'])->middleware(['auth', 'role:donor']);

Route::get('/beneficiary/request', [BeneficiaryRequestController::class, 'create']);
Route::post('/beneficiary/request', [BeneficiaryRequestController::class, 'store']);
// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::post('/notifications/read-all', function () {
    auth()->user()->unreadNotifications->markAsRead();

    return back()->with('success', 'Notifications marked as read.');
})->middleware('auth');

Route::get('/admin/inventory', [InventoryController::class, 'index'])->middleware(['auth', 'role:admin']);
Route::post('/admin/inventory/{inventory}', [InventoryController::class, 'update'])->middleware(['auth', 'role:admin']);
// All protected routes
Route::middleware('auth')->group(function () {

    // one dashboard entry point (auto loads correct role dashboard)
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
    // Donor
    Route::get('/donor/dashboard', function () {

        $uid = auth()->id();

        $stats = [
            'my_donations' => Donation::where('donor_id', $uid)->count(),
            'pending_donations' => Donation::where('donor_id', $uid)->where('status', 'Pending')->count(),
            'collected_donations' => Donation::where('donor_id', $uid)->where('status', 'Collected')->count(),
            'distributed_donations' => Donation::where('donor_id', $uid)->where('status', 'Distributed')->count(),
        ];

        return view('dashboards.donor', compact('stats'));

    })->middleware(['auth', 'role:donor']);

    // tasks
    Route::get('/tasks', [TaskController::class, 'index'])->middleware('auth');
    Route::post('/tasks/{task}/complete', [TaskController::class, 'complete'])->middleware('auth');

    // Admin
    Route::get('/admin/dashboard', function () {

        $stats = [
            'total_users' => User::count(),
            'total_donors' => User::where('role', 'donor')->count(),
            'total_volunteers' => User::where('role', 'volunteer')->count(),
            'total_donations' => Donation::count(),
            'inventory_rows' => Inventory::count(),
            'inventory_stock' => Inventory::sum('available_quantity'),
            'tasks_total' => Task::count(),
            'tasks_completed' => Task::where('status', 'Completed')->count(),
        ];

        return view('dashboards.admin', compact('stats'));

    })->middleware(['auth', 'role:admin']);

    // Volunteer
    Route::get('/volunteer/dashboard', function () {

        $uid = auth()->id();

        $stats = [
            'assigned_tasks' => Task::where('volunteer_id', $uid)->count(),
            'pending_tasks' => Task::where('volunteer_id', $uid)->where('status', '!=', 'Completed')->count(),
            'completed_tasks' => Task::where('volunteer_id', $uid)->where('status', 'Completed')->count(),
            'pickup_tasks' => Task::where('volunteer_id', $uid)->where('type', 'pickup')->count(),
            'distribution_tasks' => Task::where('volunteer_id', $uid)->where('type', 'distribution')->count(),
        ];

        return view('dashboards.volunteer', compact('stats'));

    })->middleware(['auth', 'role:volunteer']);
});
