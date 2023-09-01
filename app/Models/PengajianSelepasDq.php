<?php

namespace App\Models;

use App\Models\Base as Model;

class PengajianSelepasDq extends Model
{
    protected $table = 'pengajian_selepas_dq';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'id');
    }

}