<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = ['item_id', 'available_quantity', 'location'];

    public function item()
    {
        return $this->belongsTo(ClothingItem::class, 'item_id');
    }
}
