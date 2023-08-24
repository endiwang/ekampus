<?php

namespace App\Models;

use App\Models\Base as Model;

class PelajarSemester extends Model
{
    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'pelajar_id_old');
    }

    public function pelajarSemesterDetails()
    {
        return $this->hasMany(PelajarSemesterDetail::class, 'pelajar_semester_id', 'id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester', 'id');
    }

    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi_id', 'id');
    }
}
