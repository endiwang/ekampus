<?php

namespace App\Models\Pentadbiran;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fasiliti extends Model
{
    use HasFactory;

    protected $table = 'fasiliti';

    protected $guarded = ['id'];

    // public function uploadby()
    // {
    //     return $this->belongsTo('App\Models\User','upload_by','id');
    // }

}
