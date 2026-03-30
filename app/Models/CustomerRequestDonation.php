<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerRequestDonation extends Model
{
    protected $fillable = [
        'customer_request_id',
        'donor_id',
        'note',
        'status',
    ];

    public function customerRequest()
    {
        return $this->belongsTo(CustomerRequest::class);
    }

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }
}
