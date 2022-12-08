<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Pelajar extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'pelajar';
    protected $guarded = ['id'];

    public function sesi()
    {
        return $this->belongsTo(Sesi::class,'sesi_id','id');
    }

    public function pusat_pengajian()
    {
        return $this->belongsTo(PusatPengajian::class,'pusat_pengajian_id','id');
    }

    public function kursus()
    {
        return $this->belongsTo(Kursus::class,'kursus_id','id');
    }



}


