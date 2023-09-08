<?php

namespace App\Models;

use App\Models\Base as Model;

class PenggunaanKemudahanBilik extends Model
{
    protected $table = 'penggunaan_kemudahan_bilik';

    public function bilik()
    {
        return $this->belongsTo(BilikAsrama::class, 'bilik_asrama_id', 'id');
    }

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'id');
    }

}
