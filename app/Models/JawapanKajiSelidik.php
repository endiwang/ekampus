<?php

namespace App\Models;


use App\Models\Base as Model;

class JawapanKajiSelidik extends Model
{


    protected $table = 'jawapan_kaji_selidik';

    protected $guarded = ['id'];

    public function Form()
    {
        return $this->hasOne('App\Models\BorangKajiSelidik', 'id', 'borang_kaji_selidik_id');
    }
}
