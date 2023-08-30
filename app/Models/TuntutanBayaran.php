<?php

namespace App\Models;

use App\Models\Base as Model;

class TuntutanBayaran extends Model
{
    protected $guarded = ['id'];

    public function sesi()
    {
        return $this->belongsTo(SesiPeperiksaan::class, 'sesi_id', 'id');
    }
}
