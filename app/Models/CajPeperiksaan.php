<?php

namespace App\Models;

use App\Models\Base as Model;

class CajPeperiksaan extends Model
{
    protected $table = 'caj_peperiksaan';
    protected $guarded = ['id'];

    public function subjek()
    {
        return $this->belongsTo(Subjek::class);
    }
}
