<?php

namespace App\Models;


use App\Models\Base as Model;

class PenilaianBerterusan extends Model
{


    protected $table = 'penilaian_berterusan';

    protected $guarded = ['id'];

    public function subjek()
    {
        return $this->belongsTo(Subjek::class, 'subjek_id', 'id');
    }
}
