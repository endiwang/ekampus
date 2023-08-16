<?php

namespace App\Models\Kualiti;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Penyelidikan extends Model
{
    use HasFactory;
    protected $table = 'penyelidikan';
    protected $guarded = ['id'];


    // public function uploadby()
    // {
    //     return $this->belongsTo('App\Models\User','upload_by','id');
    // }

}
