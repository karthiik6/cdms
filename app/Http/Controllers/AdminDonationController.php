<?php

namespace App\Http\Controllers;

use App\Models\Donation;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminDonationController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $q = $request->query('q');         // search text
        $status = $request->query('status'); // Pending/Collected/Distributed

        $donationsQuery = \App\Models\Donation::with(['donor', 'items', 'task.volunteer'])
            ->latest();

        if ($status) {
            $donationsQuery->where('status', $status);
        }

        if ($q) {
            $search = '%'.strtolower($q).'%';

            $donationsQuery->where(function ($query) use ($search) {
                $query->whereHas('donor', function ($x) use ($search) {
                    $x->whereRaw('LOWER(name) LIKE ?', [$search])
                        ->orWhereRaw('LOWER(email) LIKE ?', [$search]);
                })->orWhereRaw('LOWER(pickup_address) LIKE ?', [$search]);
            });
        }

        $donations = $donationsQuery->get();
        $volunteers = \App\Models\User::where('role', 'volunteer')->orderBy('name')->get();

        return view('admin.donations', compact('donations', 'volunteers', 'q', 'status'));
    }

    public function assignVolunteer(Request $request, Donation $donation)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'volunteer_id' => [
                'required',
                Rule::exists('users', 'id')->where('role', 'volunteer'),
            ],
        ]);

        Task::updateOrCreate(
            ['donation_id' => $donation->id],
            [
                'clothing_request_id' => null,
                'volunteer_id' => $request->volunteer_id,
                'type' => 'pickup',
                'status' => 'Assigned',
            ]
        );

        return back()->with('success', 'Volunteer assigned for pickup!');
    }

    public function updateStatus(Request $request, Donation $donation)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:Pending,Collected,Distributed',
        ]);

        $donation->update(['status' => $request->status]);

        return back()->with('success', 'Donation status updated!');
    }
}
