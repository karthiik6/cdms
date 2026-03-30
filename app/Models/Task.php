<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'donation_id',
        'clothing_request_id',
        'customer_request_id',
        'volunteer_id',
        'type',
        'status',
        'scheduled_date',
    ];

    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    public function request()
    {
        return $this->belongsTo(\App\Models\ClothingRequest::class, 'clothing_request_id');
    }

    public function volunteer()
    {
        return $this->belongsTo(User::class, 'volunteer_id');
    }

    public function customerRequest()
    {
        return $this->belongsTo(\App\Models\CustomerRequest::class, 'customer_request_id');
    }
}
