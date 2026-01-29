<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AircraftModel;

class Aircraft extends Model
{
    //error de asignación masiva.
    protected $fillable = ['registration', 'aircraft_model_id', 'is_active']; // Asegúrate de que aircraft_model_id sea "fillable"

    /**
     * Relación con el modelo de aeronave (Cessna 172, etc.)
     */
    public function aircraft_model()
    {
        // Importante: El nombre de la función debe ser aircraft_model
        return $this->belongsTo(AircraftModel::class, 'aircraft_model_id');
    }
}
