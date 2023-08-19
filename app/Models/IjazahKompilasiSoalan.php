<?php

namespace App\Models;


use App\Models\Base as Model;

class IjazahKompilasiSoalan extends Model
{


    protected $table = 'ijazah_kompilasi_soalan';

    protected $guarded = ['id'];

    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi_id', 'id');
    }
}
