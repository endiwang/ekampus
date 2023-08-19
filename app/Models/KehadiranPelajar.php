<?php

namespace App\Models;


use App\Models\Base as Model;

class KehadiranPelajar extends Model
{


    protected $table = 'kehadiran_pelajar';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'id');
    }

    public function subjek()
    {
        return $this->belongsTo(Subjek::class, 'subjek_id', 'id');
    }
}
