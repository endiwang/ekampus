<?php

namespace App\Models;

use App\Models\Base as Model;

class PelajarSemesterDetail extends Model
{
    protected $guarded = ['id'];

    public function subjek()
    {
        return $this->belongsTo(Subjek::class, 'subjek_id', 'id');
    }

    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi_id', 'id');
    }
}
