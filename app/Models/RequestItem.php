<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestItem extends Model
{
    protected $fillable = ['clothing_request_id', 'category', 'size', 'quantity'];

    public function request()
    {
        return $this->belongsTo(ClothingRequest::class, 'clothing_request_id');
    }
}
