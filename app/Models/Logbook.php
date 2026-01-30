<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    // Campos que se pueden llenar masivamente
    protected $fillable = ['name', 'date', 'user_id', 'is_active'];

    // Relación: Un Logbook pertenece a un Piloto/Usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación: Un Logbook tiene muchas entradas de vuelo
    public function logEntries()
    {
        return $this->hasMany(logEntry::class, 'logbook_id');
    }
}

