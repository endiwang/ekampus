<?php

namespace App\Models\Kualiti;

use App\Models\Base as Model;

class PenyumbangArtikel extends Model
{
    protected $table = 'penyumbang_artikel';

    protected $guarded = ['id'];

    public function approvedby()
    {
        return $this->belongsTo('App\Models\User', 'approved_by', 'id');
    }
}
