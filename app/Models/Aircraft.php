<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aircraft extends Model
{
    //error de asignación masiva.
    protected $fillable = ['registration', 'model', 'brand', 'is_active'];
}
