<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawapanKajiSelidik extends Model
{
    use HasFactory;

    protected $table = 'jawapan_kaji_selidik';
    protected $guarded = ['id'];

    public function Form()
    {
        return $this->hasOne('App\Models\BorangKajiSelidik', 'id', 'borang_kaji_selidik_id');
    }
}
