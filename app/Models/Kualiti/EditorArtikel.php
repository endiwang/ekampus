<?php

namespace App\Models\Kualiti;

use App\Models\Base as Model;

class EditorArtikel extends Model
{
    protected $table = 'editor_artikel';

    protected $guarded = ['id'];

    public function approvedby()
    {
        return $this->belongsTo('App\Models\User', 'approved_by', 'id');
    }
}
