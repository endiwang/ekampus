<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;
    protected $table = "permohonan";
    protected $guarded = ['id'];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class,'kursus_id','id');
    }

    public function keturunan()
    {
        return $this->belongsTo(Keturunan::class,'keturunan_id','id');
    }

    public function penjaga()
    {
        return $this->hasOne(PermohonanPenjaga::class,'permohonan_id','id');
    }

    public function tanggungan_penjaga()
    {
        return $this->hasMany(PermohonanTanggunganPenjaga::class,'permohonan_id','id');
    }

    public function akademik()
    {
        return $this->hasMany(PermohonanKelulusanAkademik::class,'permohonan_id','id');
    }
}
