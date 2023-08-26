<?php

namespace App\Models;

use App\Models\Base as Model;

class RayuanPermohonan extends Model
{
    protected $table = 'rayuan_permohonan';

    protected $guarded = ['id'];

    public function permohonan()
    {
        return $this->belongsTo(Permohonan::class, 'permohonan_id', 'id');
    }
}
