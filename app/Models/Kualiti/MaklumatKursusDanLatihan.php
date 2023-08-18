<?php

namespace App\Models\Kualiti;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class MaklumatKursusDanLatihan extends Model
{
    use HasFactory,SoftDeletes;
    protected $table = 'maklumat_kursus_dan_latihan';
    protected $guarded = ['id'];


    public function fkKursusDanLatihan()
    {
        return $this->belongsTo('App\Models\Kualiti\KursusDanLatihanPensyarah','fk_kursus_dan_latihan','id');
        
    }

}
