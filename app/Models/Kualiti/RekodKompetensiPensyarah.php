<?php

namespace App\Models\Kualiti;


use App\Models\Base as Model;

class RekodKompetensiPensyarah extends Model
{


    protected $table = 'rekod_kompetensi_pensyarah';

    protected $guarded = ['id'];

    // public function uploadby()
    // {
    //     return $this->belongsTo('App\Models\User','upload_by','id');
    // }

}
