<?php

namespace App\Models;

use App\Models\Base as Model;

class JabatanMurajaahHarian extends Model
{
    protected $table = 'jabatan_murajaah_harian';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'id');
    }
}
