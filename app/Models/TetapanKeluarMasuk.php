<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TetapanKeluarMasuk extends Model
{
    use HasFactory;

    protected $table = 'tetapan_keluar_masuk';
    protected $guarded = ['id'];

    public function hari()
    {
        return $this->belongsTo(Hari::class,'hari_id','id');
    }
}
