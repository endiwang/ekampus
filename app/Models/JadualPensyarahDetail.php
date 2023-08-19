<?php

namespace App\Models;


use App\Models\Base as Model;

class JadualPensyarahDetail extends Model
{


    protected $guarded = ['id'];

    public function subjek()
    {
        return $this->belongsTo(Subjek::class, 'subjek_id', 'id');
    }
}
