<?php

namespace App\Models;

use App\Models\Base as Model;

class IjazahJadualPembelajaran extends Model
{
    protected $table = 'ijazah_jadual_pembelajaran';

    protected $guarded = ['id'];

    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi_id', 'id');
    }
}
