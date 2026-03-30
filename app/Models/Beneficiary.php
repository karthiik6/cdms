<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Beneficiary extends Model
{
    protected $fillable = ['name', 'contact', 'address'];

    public function requests()
    {
        return $this->hasMany(ClothingRequest::class);
    }
}
