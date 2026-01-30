<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    public function entries() {
        return $this->hasMany(LogEntry::class);
    }
}
