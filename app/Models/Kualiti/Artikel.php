<?php

namespace App\Models\Kualiti;

use App\Models\Base as Model;

class Artikel extends Model
{
    protected $table = 'artikel';

    protected $guarded = ['id'];

    public function editor()
    {
        return $this->belongsTo('App\Models\User', 'upload_by', 'id');
    }

    public function penyumbang()
    {
        return $this->belongsTo('App\Models\User', 'penyumbang', 'id');
    }

    public function komen()
    {
        return $this->hasMany('App\Models\Kualiti\KomenArtikel', 'artikel_id', 'id');
    }
}
