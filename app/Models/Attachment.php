<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Attachment extends Model
{
    protected $guarded = ['id'];

    // Esta función permite que el adjunto sepa a quién pertenece
    public function attachable(): MorphTo
    {
        return $this->morphTo();
    }
}