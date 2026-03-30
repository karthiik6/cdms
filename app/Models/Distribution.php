<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distribution extends Model
{
    protected $fillable = ['clothing_request_id', 'inventory_id', 'allocated_quantity'];

    public function request()
    {
        return $this->belongsTo(ClothingRequest::class, 'clothing_request_id');
    }

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
