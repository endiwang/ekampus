<?php

namespace App\Models;


use App\Models\Base as Model;

class IjazahPenawaranSubjek extends Model
{


    protected $table = 'ijazah_penawaran_subjek';

    protected $guarded = ['id'];

    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi_id', 'id');
    }
}
