<?php

namespace App\Models;


use App\Models\Base as Model;

class KalendarAkademik extends Model
{


    protected $table = 'kalendar_akademik';

    protected $guarded = ['id'];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'program_id', 'id');
    }
}
