<?php

namespace App\Models\Pentadbiran;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PermohonanPeralatan extends Model
{
    use HasFactory;
    protected $table = 'permohonan_peralatan';
    protected $guarded = ['id'];


    public function fasiliti()
    {
        return $this->belongsTo('App\Models\Pentadbiran\Fasiliti','peralatan_id','id');
    }

}
