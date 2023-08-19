<?php

namespace App\Models\Kualiti;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyumbangArtikel extends Model
{
    use HasFactory;

    protected $table = 'penyumbang_artikel';

    protected $guarded = ['id'];

    public function approvedby()
    {
        return $this->belongsTo('App\Models\User', 'approved_by', 'id');
    }
}
