<?php

namespace App\Models\Kualiti;

use App\Models\Base as Model;

class KomenArtikel extends Model
{
    protected $table = 'komen_artikel';

    protected $guarded = ['id'];

    public function artikel()
    {
        return $this->belongsTo('App\Models\Kualiti\Artikel', 'artikel_id', 'id');
    }

    public function editor()
    {
        return $this->belongsTo('App\Models\User', 'editor', 'id');
    }

    public function penyumbang()
    {
        return $this->belongsTo('App\Models\User', 'penyumbang', 'id');
    }
}
