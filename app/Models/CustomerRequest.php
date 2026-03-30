<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerRequest extends Model
{
    protected $fillable = [
        'customer_id',
        'status',
        'note',
        'delivery_location',
        'contact_phone',
        'donor_donation_allowed',
        'show_volunteer_details_to_customer',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function items()
    {
        return $this->hasMany(CustomerRequestItem::class);
    }

    public function donations()
    {
        return $this->hasMany(CustomerRequestDonation::class);
    }

    public function task()
    {
        return $this->hasOne(Task::class);
    }
}
