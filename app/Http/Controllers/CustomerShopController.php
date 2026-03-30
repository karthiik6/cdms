<?php

namespace App\Http\Controllers;

use App\Models\CustomerRequest;
use App\Models\CustomerRequestItem;
use App\Models\Inventory;
use App\Models\User;
use App\Notifications\SystemAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerShopController extends Controller
{
    private function normalizeSize(?string $size): string
    {
        $value = strtolower(trim((string) $size));

        return match ($value) {
            's', 'small' => 'S',
            'm', 'medium' => 'M',
            'l', 'large' => 'L',
            'xl', 'x-large', 'extra large', 'extra-large' => 'XL',
            default => strtoupper($value ?: '-'),
        };
    }

    private function resolveShirtType(string $category, ?string $condition): string
    {
        $haystack = strtolower(trim($category.' '.($condition ?? '')));

        if (str_contains($haystack, 'half sleeve') || str_contains($haystack, 'half-sleeve')) {
            return 'Half Sleeve';
        }

        if (str_contains($haystack, 'full sleeve') || str_contains($haystack, 'full-sleeve')) {
            return 'Full Sleeve';
        }

        return 'Standard';
    }

    public function products()
    {
        if (auth()->user()->role !== 'customer') {
            abort(403);
        }

        $inventory = Inventory::with('item')
            ->where('available_quantity', '>', 0)
            ->orderBy('id', 'desc')
            ->get();

        $productOptions = $inventory
            ->filter(fn ($inv) => $inv->item && $inv->available_quantity > 0)
            ->groupBy(function ($inv) {
                $category = strtolower(trim((string) $inv->item->category));
                $size = $this->normalizeSize($inv->item->size);

                if ($category === 'shirt') {
                    return 'shirt|'.$this->resolveShirtType((string) $inv->item->category, $inv->item->condition).'|'.$size;
                }

                if ($category === 'pants' || $category === 'pant') {
                    return 'pants|'.$size;
                }

                return $category.'|'.$size;
            })
            ->map(function ($group, $groupKey) {
                $first = $group->first();
                $rawCategory = strtolower(trim((string) $first->item->category));
                $size = $this->normalizeSize($first->item->size);
                $type = '-';

                if ($rawCategory === 'shirt') {
                    $type = $this->resolveShirtType((string) $first->item->category, $first->item->condition);
                }

                $category = $rawCategory === 'pant' ? 'Pants' : ucfirst($rawCategory ?: 'Item');

                return [
                    'key' => base64_encode($groupKey),
                    'label' => $category,
                    'size' => $size,
                    'type' => $type,
                    'available' => (int) $group->sum('available_quantity'),
                    'inventory_ids' => $group->pluck('id')->values()->all(),
                ];
            })
            ->sortBy(fn ($option) => $option['label'].'|'.$option['type'].'|'.$option['size'])
            ->values();

        return view('customer.products', compact('productOptions'));
    }

    public function createRequest(Request $request)
    {
        if (auth()->user()->role !== 'customer') {
            abort(403);
        }

        $request->validate([
            'note' => 'nullable|string|max:1000',
            'delivery_location' => 'required|string|max:500',
            'items' => 'required|array|min:1',
        ]);

        $selectedGroups = collect($request->input('items', []))
            ->map(function ($group) {
                $inventoryIds = collect($group['inventory_ids'] ?? [])
                    ->filter(fn ($id) => is_numeric($id))
                    ->map(fn ($id) => (int) $id)
                    ->unique()
                    ->values();

                return [
                    'qty' => (int) ($group['qty'] ?? 0),
                    'inventory_ids' => $inventoryIds,
                ];
            })
            ->filter(fn ($group) => $group['qty'] > 0 && $group['inventory_ids']->count() > 0)
            ->values();

        if ($selectedGroups->count() === 0) {
            return back()->with('error', 'Select at least one item quantity.');
        }

        $allInventoryIds = $selectedGroups
            ->flatMap(fn ($group) => $group['inventory_ids'])
            ->unique()
            ->values();

        $inventories = Inventory::whereIn('id', $allInventoryIds)
            ->get()
            ->keyBy('id');

        if ($inventories->count() !== $allInventoryIds->count()) {
            return back()->with('error', 'One or more selected inventory items are invalid.');
        }

        foreach ($selectedGroups as $group) {
            $groupAvailable = $group['inventory_ids']->sum(function ($id) use ($inventories) {
                return (int) optional($inventories->get($id))->available_quantity;
            });

            if ($groupAvailable < $group['qty']) {
                return back()->with('error', 'Requested quantity exceeds available stock for one or more items.');
            }
        }

        $cr = null;
        DB::transaction(function () use ($request, $selectedGroups, $inventories, &$cr) {
            $cr = CustomerRequest::create([
                'customer_id' => auth()->id(),
                'status' => 'Pending',
                'note' => $request->note,
                'delivery_location' => $request->delivery_location,
                'donor_donation_allowed' => false,
            ]);

            foreach ($selectedGroups as $group) {
                $remaining = $group['qty'];

                foreach ($group['inventory_ids'] as $inventoryId) {
                    if ($remaining <= 0) {
                        break;
                    }

                    $inventory = $inventories->get($inventoryId);
                    if (! $inventory || $inventory->available_quantity <= 0) {
                        continue;
                    }

                    $alloc = min($remaining, (int) $inventory->available_quantity);
                    if ($alloc <= 0) {
                        continue;
                    }

                    CustomerRequestItem::create([
                        'customer_request_id' => $cr->id,
                        'inventory_id' => $inventoryId,
                        'quantity' => $alloc,
                    ]);

                    $remaining -= $alloc;
                }
            }
        });

        User::where('role', 'admin')->get()->each(function ($admin) use ($cr) {
            $admin->notify(new SystemAlert(
                'New Customer Request',
                "A new customer request #{$cr->id} has been submitted.",
                '/admin/customer-requests'
            ));
        });

        return redirect('/customer/requests')->with('success', 'Request submitted to admin!');
    }

    public function myRequests()
    {
        if (auth()->user()->role !== 'customer') {
            abort(403);
        }

        $requests = CustomerRequest::with('items.inventory.item')
            ->with('donations.donor')
            ->withCount('donations')
            ->where('customer_id', auth()->id())
            ->latest()
            ->get();

        return view('customer.requests', compact('requests'));
    }
}
