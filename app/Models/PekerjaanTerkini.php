<?php

namespace App\Models;

use App\Models\Base as Model;

class PekerjaanTerkini extends Model
{
    protected $table = 'pekerjaan_alumni';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'id');
    }
}