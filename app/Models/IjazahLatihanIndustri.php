<?php

namespace App\Models;

use App\Models\Base as Model;

class IjazahLatihanIndustri extends Model
{
    protected $table = 'ijazah_latihan_industri';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'id');
    }
}
