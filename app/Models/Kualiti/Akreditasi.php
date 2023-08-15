<?php

namespace App\Models\Kualiti;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Akreditasi extends Model
{
    use HasFactory;
    protected $table = 'akreditasi';
    protected $guarded = ['id'];


    public function uploadby()
    {
        return $this->belongsTo('App\Models\User','upload_by','id');
    }

}
