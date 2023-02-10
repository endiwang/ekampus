<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permohonan extends Model
{
    use HasFactory;
    protected $table = "permohonan";
    protected $guarded = ['id'];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class,'kursus_id','id');
    }
}
