<?php

namespace App\Http\Controllers;

use App\Models\ClothingRequest;
use App\Models\Distribution;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminRequestController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $requests = ClothingRequest::with(['beneficiary', 'items', 'task.volunteer', 'allocations.inventory.item'])
            ->latest()->get();

        $volunteers = User::where('role', 'volunteer')->orderBy('name')->get();

        return view('admin.requests', compact('requests', 'volunteers'));
    }

    public function assignVolunteer(Request $request, ClothingRequest $clothingRequest)
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

        \App\Models\Task::updateOrCreate(
            ['clothing_request_id' => $clothingRequest->id],
            [
                'donation_id' => null,
                'volunteer_id' => $request->volunteer_id,
                'type' => 'distribution',
                'status' => 'Assigned',
            ]
        );

        return back()->with('success', 'Volunteer assigned for distribution!');
    }

    // Approve + Allocate from inventory (simple auto allocation)
    public function approveAndAllocate(ClothingRequest $clothingRequest)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        if ($clothingRequest->status === 'Completed') {
            return back()->with('success', 'Already completed.');
        }

        $fullySatisfied = true;
        $allocatedAnything = false;

        foreach ($clothingRequest->items as $ri) {

            $needed = (int) $ri->quantity;

            $inv = Inventory::whereHas('item', function ($q) use ($ri) {
                $q->where('category', $ri->category)
                    ->where('size', $ri->size);
            })
                ->where('available_quantity', '>', 0)
                ->first();

            if (! $inv) {
                $fullySatisfied = false;

                continue; // nothing available
            }

            $alloc = min($needed, (int) $inv->available_quantity);

            if ($alloc <= 0) {
                $fullySatisfied = false;

                continue;
            }

            $allocatedAnything = true;

            $inv->available_quantity -= $alloc;
            $inv->save();

            Distribution::create([
                'clothing_request_id' => $clothingRequest->id,
                'inventory_id' => $inv->id,
                'allocated_quantity' => $alloc,
            ]);

            if ($alloc < $needed) {
                $fullySatisfied = false;
            }
        }

        // If nothing could be allocated at all, keep it Pending and show message
        if (! $allocatedAnything) {
            $clothingRequest->status = 'Pending';
            $clothingRequest->save();

            return back()->withErrors([
                'inventory' => 'No matching stock available in inventory for this request.',
            ]);
        }

        $clothingRequest->status = $fullySatisfied ? 'Approved' : 'Partially Approved';
        $clothingRequest->save();

        return back()->with('success', $fullySatisfied
            ? 'Request approved and fully allocated!'
            : 'Partially allocated. Waiting for more stock.');
    }
}
