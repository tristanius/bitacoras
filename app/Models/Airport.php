<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    // Definimos qué campos se pueden llenar masivamente
    protected $fillable = ['icao_code', 'name', 'is_active'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'airport_user')
                    ->withTimestamps();
    }
}