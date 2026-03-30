<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Donation extends Model
{
    protected $fillable = ['donor_id', 'donation_date', 'pickup_address', 'contact_phone', 'status', 'show_volunteer_details_to_donor', 'photo'];

    protected $appends = ['photo_url'];

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

    public function getPhotoUrlAttribute(): ?string
    {
        if (! $this->photo) {
            return null;
        }

        if (Storage::disk('public')->exists($this->photo)) {
            return route('donations.photo', ['path' => $this->photo]);
        }

        return null;
    }
}
