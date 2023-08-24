<?php

namespace App\Models;

use App\Models\Base as Model;

class IjazahAkademik extends Model
{
    protected $table = 'ijazah_akademik';

    protected $guarded = ['id'];

    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi_id', 'id');
    }
}
