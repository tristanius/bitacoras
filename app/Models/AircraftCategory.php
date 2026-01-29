<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Aircraft;

class AircraftCategory extends Model
{
    protected $fillable = ['name', 'description'];

    // Relación: Una categoría tiene muchos modelos de avión
    public function models()
    {
        return $this->hasMany(Aircraft::class);
    }
}