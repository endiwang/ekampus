<?php

namespace App\Models\Kualiti;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class RekodKompetensiPensyarah extends Model
{
    use HasFactory;
    protected $table = 'rekod_kompetensi_pensyarah';
    protected $guarded = ['id'];


    // public function uploadby()
    // {
    //     return $this->belongsTo('App\Models\User','upload_by','id');
    // }

}
