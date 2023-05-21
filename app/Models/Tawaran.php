<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tawaran extends Model
{
    use HasFactory;
    protected $table = 'tawaran';
    protected $guarded = ['id'];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class,'kursus_id','id');
    }

    public function sesi()
    {
        return $this->belongsTo(Sesi::class,'sesi_id','id');
    }
}
