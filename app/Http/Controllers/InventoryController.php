<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $inventory = Inventory::with('item.donation.donor')
            ->latest()
            ->get();

        return view('admin.inventory', compact('inventory'));
    }

    public function update(Request $request, Inventory $inventory)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'available_quantity' => 'required|integer|min:0',
            'location' => 'nullable|string|max:100',
        ]);

        $inventory->update([
            'available_quantity' => $request->available_quantity,
            'location' => $request->location,
        ]);

        return back()->with('success', 'Inventory updated!');
    }
}
