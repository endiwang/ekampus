<?php

namespace App\Models\Kualiti;

use App\Models\Base as Model;

class Penyelidikan extends Model
{
    protected $table = 'penyelidikan';

    protected $guarded = ['id'];

    // public function uploadby()
    // {
    //     return $this->belongsTo('App\Models\User','upload_by','id');
    // }

}
