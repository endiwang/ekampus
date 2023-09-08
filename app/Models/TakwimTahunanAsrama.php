<?php

namespace App\Models;

use App\Models\Base as Model;

class TakwimTahunanAsrama extends Model
{
    protected $table = 'takwim_tahunan_asrama';

    public function blok()
    {
        return $this->belongsTo(Blok::class, 'blok_id', 'id');
    }
}
