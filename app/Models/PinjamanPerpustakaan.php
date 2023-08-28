<?php

namespace App\Models;

use App\Models\Base as Model;

class PinjamanPerpustakaan extends Model
{
    protected $table = 'perpustakaan_pinjaman';

    protected $guarded = ['id'];

    public function bahan()
    {
        return $this->belongsTo(BahanPerpustakaan::class, 'bahan_id', 'id');
    }

    public function ahli()
    {
        return $this->belongsTo(KeahlianPerpustakaan::class, 'keahlian_id', 'id');
    }
}
