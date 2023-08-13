<?php

namespace App\Models\Kualiti;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class KomenArtikel extends Model
{
    use HasFactory;
    protected $table = 'komen_artikel';
    protected $guarded = ['id'];


    public function artikel()
    {
        return $this->belongsTo('App\Models\Kualiti\Artikel','artikel_id','id');
    }

    public function editor()
    {
        return $this->belongsTo('App\Models\User','editor','id');
    }

    public function penyumbang()
    {
        return $this->belongsTo('App\Models\User','penyumbang','id');
    }

}
