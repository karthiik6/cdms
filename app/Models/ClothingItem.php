<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClothingItem extends Model
{
    protected $fillable = ['donation_id', 'category', 'size', 'condition', 'quantity'];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function inventory()
    {
        return $this->hasOne(\App\Models\Inventory::class, 'item_id');
    }
}
