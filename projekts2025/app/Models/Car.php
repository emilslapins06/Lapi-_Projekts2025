<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    protected $fillable = ['brand', 'model', 'year', 'mileage'];

    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->withPivot('confirmed')
                    ->withTimestamps();
    }
}