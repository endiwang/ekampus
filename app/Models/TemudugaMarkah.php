<?php

namespace App\Models;


use App\Models\Base as Model;

class TemudugaMarkah extends Model
{


    protected $table = 'temuduga_markah';

    protected $guarded = ['id'];

    public function pemohon()
    {
        return $this->belongsTo(Permohonan::class, 'permohonan_id');
    }
}
