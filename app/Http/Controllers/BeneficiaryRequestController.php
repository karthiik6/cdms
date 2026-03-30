<?php

namespace App\Http\Controllers;

use App\Models\Beneficiary;
use App\Models\ClothingRequest;
use App\Models\RequestItem;
use Illuminate\Http\Request;

class BeneficiaryRequestController extends Controller
{
    public function create()
    {
        return view('beneficiary.request_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:120',
            'contact' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'request_date' => 'nullable|date',

            'items' => 'required|array|min:1',
            'items.*.category' => 'required|string|max:50',
            'items.*.size' => 'required|string|max:10',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $beneficiary = Beneficiary::create([
            'name' => $request->name,
            'contact' => $request->contact,
            'address' => $request->address,
        ]);

        $cr = ClothingRequest::create([
            'beneficiary_id' => $beneficiary->id,
            'request_date' => $request->request_date,
            'status' => 'Pending',
        ]);

        foreach ($request->items as $it) {
            RequestItem::create([
                'clothing_request_id' => $cr->id,
                'category' => $it['category'],
                'size' => $it['size'],
                'quantity' => $it['quantity'],
            ]);
        }

        return redirect('/beneficiary/request')->with('success', 'Request submitted!');
    }
}
