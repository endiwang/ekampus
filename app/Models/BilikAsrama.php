<?php

namespace App\Models;

use App\Models\Base as Model;

class BilikAsrama extends Model
{
    protected $table = 'bilik_asrama';

    protected $fillable = ['id', 'tingkat_id','blok_id','no_bilik','status_bilik','keadaan_bilik','jenis_bilik','kekosongan', 'is_deleted'];

    public function blok()
    {
        return $this->belongsTo(Blok::class, 'blok_id', 'id');
    }

    public function aras()
    {
        return $this->belongsTo(Tingkat::class, 'tingkat_id', 'id');
    }
}
