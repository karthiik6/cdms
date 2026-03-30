<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->role !== 'volunteer') {
            abort(403);
        }

        $status = $request->query('status'); // filter value

        $query = auth()->user()->tasks()
            ->with([
                'donation.donor',
                'donation.items',
                'request.beneficiary',
                'request.items',
                'customerRequest.customer',
                'customerRequest.items.inventory.item',
            ])
            ->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $tasks = $query->get();

        return view('volunteer.tasks', compact('tasks', 'status'));
    }

    public function complete(Task $task)
    {
        if (auth()->user()->role !== 'volunteer') {
            abort(403);
        }
        if ($task->volunteer_id !== auth()->id()) {
            abort(403);
        }

        $task->update(['status' => 'Completed']);

        // PICKUP FLOW: mark donation collected + update inventory
        if ($task->type === 'pickup' && $task->donation) {

            $donation = $task->donation;

            // Mark donation as collected
            $donation->update(['status' => 'Collected']);

            // Update inventory from collected items
            foreach ($donation->items as $item) {
                $inv = Inventory::where('item_id', $item->id)->first();

                if (! $inv) {
                    Inventory::create([
                        'item_id' => $item->id,
                        'available_quantity' => $item->quantity,
                        'location' => 'Main Storage',
                    ]);
                } else {
                    $inv->available_quantity += $item->quantity;
                    $inv->save();
                }
            }

            return back()->with('success', 'Pickup collected successfully. Donation marked Collected and inventory updated.');
        }

        // DELIVERY FLOW: mark linked request completed
        if (in_array($task->type, ['distribution', 'customer_delivery'], true)) {
            if ($task->request) {
                $task->request->update(['status' => 'Completed']);

                return back()->with('success', 'Distribution completed! Request marked Completed.');
            }

            if ($task->customerRequest) {
                $task->customerRequest->update(['status' => 'Completed']);

                return back()->with('success', 'Customer delivery completed! Request marked Completed.');
            }
        }

        // Fallback if task has missing links
        return back()->with('success', 'Task completed!');
    }
}
