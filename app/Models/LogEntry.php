<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class logEntry extends Model
{
    protected $fillable = [
        'logbook_id', 'aircraft_id', 'origin_id', 'destination_id', 'date',
        'hobbs_out', 'hobbs_in', 'total_time',
        'pic_time', 'sic_time', 'solo_time', 'dual_time', 'cfi_time', 'xc_time',
        'night_time', 'instr_actual', 'instr_sim', 'simulator_time',
        'landings_day', 'landings_night',
        'approaches', 'holds', 'remarks', 'instructor_id', 'pilot_id', 'instructor_certified_at'
    ];

    public function logbook() { return $this->belongsTo(Logbook::class); }
    public function aircraft() { return $this->belongsTo(Aircraft::class); }
    public function instructor() { return $this->belongsTo(User::class, 'instructor_id'); }
    public function origin() { return $this->belongsTo(Airport::class, 'origin_id'); }
    public function destination() { return $this->belongsTo(Airport::class, 'destination_id'); }
    
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}