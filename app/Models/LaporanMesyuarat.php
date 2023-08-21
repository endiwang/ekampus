<?php

namespace App\Models;

use App\Models\Base as Model;

class LaporanMesyuarat extends Model
{
    protected $table = 'laporan_mesyuarat';

    protected $guarded = ['id'];

    public function files()
    {
        return $this->hasMany(LaporanMesyuaratDetail::class, 'laporan_mesyuarat_id', 'id');
    }
}
