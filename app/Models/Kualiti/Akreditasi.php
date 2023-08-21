<?php

namespace App\Models\Kualiti;

use App\Models\Base as Model;

class Akreditasi extends Model
{
    protected $table = 'akreditasi';

    protected $guarded = ['id'];

    public function uploadby()
    {
        return $this->belongsTo('App\Models\User', 'upload_by', 'id');
    }
}
