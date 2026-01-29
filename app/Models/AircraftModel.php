<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AircraftModel extends Model
{
    protected $fillable = ['name', 'manufacturer'];

    // Relación: Una categoría tiene muchos modelos de avión
    public function category()
    {
        return $this->belongsTo(AircraftCategory::class, 'aircraft_category_id');
    }
}
