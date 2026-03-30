<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerRequestItem extends Model
{
    protected $fillable = ['customer_request_id', 'inventory_id', 'quantity'];

    public function request()
    {
        return $this->belongsTo(CustomerRequest::class, 'customer_request_id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
