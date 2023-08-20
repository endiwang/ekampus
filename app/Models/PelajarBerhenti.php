<?php

namespace App\Models;

use App\Models\Base as Model;

class PelajarBerhenti extends Model
{
    protected $table = 'pelajar_berhenti';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'id');
    }

    public function pelajarOld()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'pelajar_id_old');
    }
}
