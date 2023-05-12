<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaporanMesyuarat extends Model
{
    use HasFactory;
    protected $table = 'laporan_mesyuarat';
    protected $guarded = ['id'];

    public function files()
    {
        return $this->hasMany(LaporanMesyuaratDetail::class, 'laporan_mesyuarat_id','id');
    }
}
