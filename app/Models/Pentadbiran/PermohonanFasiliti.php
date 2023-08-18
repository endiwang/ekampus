<?php

namespace App\Models\Pentadbiran;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PermohonanFasiliti extends Model
{
    use HasFactory;
    protected $table = 'permohonan_fasiliti';
    protected $guarded = ['id'];


    public function fasiliti()
    {
        return $this->belongsTo('App\Models\Pentadbiran\Fasiliti','fasiliti_id','id');
    }

    public function approvedby()
    {
        return $this->belongsTo('App\Models\User','approved_by','id');
    }

    
}
