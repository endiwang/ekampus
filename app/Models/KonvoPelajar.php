<?php

namespace App\Models;

use App\Models\Base as Model;

class KonvoPelajar extends Model
{
    protected $table = 'konvo_pelajar';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id');
    }
}
