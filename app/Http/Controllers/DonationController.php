<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function create()
    {
        if (auth()->user()->role !== 'donor') {
            abort(403);
        }

        return view('donations.create');
    }

    public function index(Request $request)
    {
        if (auth()->user()->role !== 'donor') {
            abort(403);
        }

        $status = $request->query('status');

        $query = \App\Models\Donation::with(['items', 'task.volunteer'])
            ->where('donor_id', auth()->id())
            ->latest();

        if ($status) {
            $query->where('status', $status);
        }

        $donations = $query->get();

        return view('donor.donations', compact('donations', 'status'));
    }

    public function store(Request $request)
    {
        if (auth()->user()->role !== 'donor') {
            abort(403);
        }

        $request->validate([
            'donation_date' => 'nullable|date',
            'pickup_address' => 'required|string|max:1000',
            'contact_phone' => ['required', 'string', 'max:20', 'regex:/^[0-9+()\\-\\s]{7,20}$/'],
            'items' => 'required|array|min:1',
            'items.*.category' => 'required|string',
            'items.*.size' => 'required|string',
            'items.*.condition' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ✅ Store uploaded photo
        $photoPath = $request->file('photo')->store('donation_photos', 'public');

        // IMPORTANT: if you kept item2 optional, filter empty rows:
        $items = array_filter($request->items, function ($it) {
            return ! empty($it['category']) && ! empty($it['size']) && ! empty($it['condition']) && ! empty($it['quantity']);
        });

        if (count($items) === 0) {
            return back()->withErrors(['items' => 'Please enter at least one clothing item.']);
        }

        $donation = \App\Models\Donation::create([
            'donor_id' => auth()->id(),
            'donation_date' => $request->donation_date,
            'pickup_address' => $request->pickup_address,
            'contact_phone' => $request->contact_phone,
            'status' => 'Pending',
            'photo' => $photoPath,
        ]);

        foreach ($items as $it) {
            \App\Models\ClothingItem::create([
                'donation_id' => $donation->id,
                'category' => $it['category'],
                'size' => $it['size'],
                'condition' => $it['condition'],
                'quantity' => $it['quantity'],
            ]);
        }

        return redirect('/donations')->with('success', 'Donation submitted!');
    }
}
