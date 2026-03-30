<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClothingRequest extends Model
{
    protected $fillable = ['beneficiary_id', 'request_date', 'status'];

    public function beneficiary()
    {
        return $this->belongsTo(Beneficiary::class);
    }

    public function items()
    {
        return $this->hasMany(RequestItem::class, 'clothing_request_id');
    }

    public function allocations()
    {
        return $this->hasMany(Distribution::class, 'clothing_request_id');
    }

    public function task()
    {
        return $this->hasOne(Task::class, 'clothing_request_id');
    }
}
