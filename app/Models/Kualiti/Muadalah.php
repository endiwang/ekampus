<?php

namespace App\Models\Kualiti;

use App\Models\Base as Model;

class Muadalah extends Model
{
    protected $table = 'muadalah';

    protected $guarded = ['id'];

    public function uploadby()
    {
        return $this->belongsTo('App\Models\User', 'upload_by', 'id');
    }
}
