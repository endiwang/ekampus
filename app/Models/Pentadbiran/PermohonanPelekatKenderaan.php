<?php

namespace App\Models\Pentadbiran;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PermohonanPelekatKenderaan extends Model
{
    use HasFactory;
    protected $table = 'permohonan_pelekat_kenderaan';
    protected $guarded = ['id'];

    public function approvedby()
    {
        return $this->belongsTo('App\Models\User','approved_by','id');
    }

    
}
