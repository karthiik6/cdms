<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = ['donor_id', 'donation_date', 'pickup_address', 'contact_phone', 'status', 'show_volunteer_details_to_donor', 'photo'];

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    public function items()
    {
        return $this->hasMany(ClothingItem::class);
    }

    public function task()
    {
        return $this->hasOne(Task::class);
    }
}
