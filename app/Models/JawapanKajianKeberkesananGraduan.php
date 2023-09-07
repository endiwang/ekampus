<?php

namespace App\Models;

use App\Models\Base as Model;

class JawapanKajianKeberkesananGraduan extends Model
{

    protected $table = 'jawapan_kajian_keberkesanan_graduan';

    protected $guarded = ['id'];

    public function Form()
    {
        return $this->hasOne('App\Models\KajianKeberkesananGraduan', 'id', 'borang_kaji_selidik_id');
    }
}