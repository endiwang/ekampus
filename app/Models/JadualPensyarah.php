<?php

namespace App\Models;

use App\Models\Base as Model;

class JadualPensyarah extends Model
{
    protected $table = 'jadual_pensyarah';

    protected $guarded = ['id'];

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }

    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi_id', 'id');
    }
}
