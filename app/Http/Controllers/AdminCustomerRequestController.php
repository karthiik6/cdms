<?php

namespace App\Http\Controllers;

use App\Models\CustomerRequest;
use App\Models\CustomerRequestDonation;
use App\Models\Inventory;
use App\Models\Task;
use App\Models\User;
use App\Notifications\SystemAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AdminCustomerRequestController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $requests = CustomerRequest::with('customer', 'items.inventory.item', 'task.volunteer', 'donations.donor')
            ->withCount('donations')
            ->latest()
            ->get();

        $volunteers = User::where('role', 'volunteer')
            ->orderBy('name')
            ->get();

        return view('admin.customer_requests', compact('requests', 'volunteers'));
    }

    // ✅ Approve request: only deduct stock + mark approved
    // (DO NOT create task here because volunteer_id is required in tasks table)
    public function approve(CustomerRequest $customerRequest)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        if ($customerRequest->status !== 'Pending') {
            return back()->with('success', 'Already processed.');
        }

        $stockError = null;

        DB::transaction(function () use ($customerRequest, &$stockError) {
            $items = $customerRequest->items()->get();
            $lockedInventory = [];

            foreach ($items as $it) {
                $inv = Inventory::with('item')
                    ->lockForUpdate()
                    ->find($it->inventory_id);

                if (! $inv || $inv->available_quantity < $it->quantity) {
                    $name = ($inv && $inv->item)
                        ? ($inv->item->category.' '.$inv->item->size)
                        : 'Item';

                    $stockError = "Not enough stock for {$name} (need {$it->quantity}).";

                    return;
                }

                $lockedInventory[$it->id] = $inv;
            }

            foreach ($items as $it) {
                $inv = $lockedInventory[$it->id];
                $inv->available_quantity -= $it->quantity;
                $inv->save();
            }

            $customerRequest->status = 'Approved';
            $customerRequest->save();
        });

        if ($stockError) {
            return back()->with('error', $stockError);
        }

        $customerRequest->customer?->notify(new SystemAlert(
            'Customer Request Approved',
            "Your request #{$customerRequest->id} was approved by admin.",
            '/customer/requests'
        ));

        return back()->with('success', 'Request approved and stock updated. Now assign a volunteer.');
    }

    // ✅ Assign volunteer: create task WITH volunteer_id (required)
    public function assignVolunteer(Request $request, CustomerRequest $customerRequest)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        // You should only assign after approval
        if ($customerRequest->status !== 'Approved') {
            return back()->with('error', 'Approve the request first, then assign a volunteer.');
        }

        $request->validate([
            'volunteer_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'volunteer'),
            ],
            'show_volunteer_details_to_customer' => 'nullable|boolean',
        ]);

        $customerRequest->update([
            'show_volunteer_details_to_customer' => $request->boolean('show_volunteer_details_to_customer'),
        ]);

        Task::updateOrCreate(
            ['customer_request_id' => $customerRequest->id],
            [
                'donation_id' => null,
                'clothing_request_id' => null,
                'volunteer_id' => $request->volunteer_id, // ✅ required
                'type' => 'customer_delivery',
                'status' => 'Assigned',
            ]
        );

        $volunteer = User::find($request->volunteer_id);
        $volunteer?->notify(new SystemAlert(
            'New Customer Delivery Task',
            "You have been assigned to customer request #{$customerRequest->id}.",
            '/tasks'
        ));

        $customerRequest->customer?->notify(new SystemAlert(
            'Volunteer Assigned',
            'A volunteer has been assigned for your approved customer request.',
            '/customer/requests'
        ));

        return back()->with('success', 'Volunteer assigned to customer delivery task.');
    }

    public function updateVolunteerSharing(Request $request, CustomerRequest $customerRequest)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'show_volunteer_details_to_customer' => 'required|boolean',
        ]);

        $customerRequest->update([
            'show_volunteer_details_to_customer' => (bool) $request->show_volunteer_details_to_customer,
        ]);

        return back()->with('success', 'Customer volunteer visibility updated.');
    }

    public function setDonorDonationPermission(Request $request, CustomerRequest $customerRequest)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        if ($customerRequest->status !== 'Approved') {
            return back()->with('error', 'Only approved requests can be opened for donor donations.');
        }

        $request->validate([
            'allowed' => 'required|boolean',
        ]);

        $customerRequest->donor_donation_allowed = (bool) $request->allowed;
        $customerRequest->save();

        $customerRequest->customer?->notify(new SystemAlert(
            'Donor Support Setting Updated',
            $customerRequest->donor_donation_allowed
                ? 'Admin enabled donor support for your request.'
                : 'Admin disabled donor support for your request.',
            '/customer/requests'
        ));

        if ($customerRequest->donor_donation_allowed) {
            return back()->with('success', 'Donors can now donate to this customer request.');
        }

        return back()->with('success', 'Donor donations have been disabled for this customer request.');
    }

    public function reject(CustomerRequest $customerRequest)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $customerRequest->status = 'Rejected';
        $customerRequest->save();

        $customerRequest->customer?->notify(new SystemAlert(
            'Customer Request Rejected',
            "Your request #{$customerRequest->id} was rejected by admin.",
            '/customer/requests'
        ));

        return back()->with('success', 'Request rejected.');
    }

    public function updateDonationStatus(Request $request, CustomerRequest $customerRequest, CustomerRequestDonation $donation)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        if ($donation->customer_request_id !== $customerRequest->id) {
            abort(404);
        }

        $request->validate([
            'status' => 'required|in:Pledged,Accepted,Completed,Rejected',
        ]);

        $donation->status = $request->status;
        $donation->save();

        $donation->donor?->notify(new SystemAlert(
            'Donation Status Updated',
            "Your donation for request #{$customerRequest->id} is now {$donation->status}.",
            '/donor/customer-requests'
        ));

        $customerRequest->customer?->notify(new SystemAlert(
            'Donor Donation Updated',
            "A donor contribution for your request #{$customerRequest->id} is now {$donation->status}.",
            '/customer/requests'
        ));

        return back()->with('success', 'Donor donation status updated successfully.');
    }
}
