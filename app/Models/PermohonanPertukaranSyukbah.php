<?php

namespace App\Models;


use App\Models\Base as Model;

class PermohonanPertukaranSyukbah extends Model
{


    protected $table = 'permohonan_pertukaran_syukbah';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'id');
    }

    public function newSyukbah()
    {
        return $this->belongsTo(Syukbah::class, 'new_syukbah_id', 'id');
    }

    public function oldSyukbah()
    {
        return $this->belongsTo(Syukbah::class, 'old_syukbah_id', 'id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }
}
