<?php

namespace App\Models;

use App\Models\Base as Model;

class BantuanKebajikan extends Model
{
    protected $table = 'bantuan_kebajikan';

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'id');
    }

}
