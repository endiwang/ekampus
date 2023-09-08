<?php

namespace App\Models;

use App\Models\Base as Model;

class KemasukanAsrama extends Model
{
    protected $table = 'kemasukan_asrama';

    public function bilik()
    {
        return $this->belongsTo(BilikAsrama::class, 'bilik_asrama_id', 'id');
    }

    public function pelajar()
    {
        return $this->hasOne(Pelajar::class, 'id', 'pelajar_id');
    }
}
