<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Temuduga extends Model
{
    use HasFactory;
    protected $table = 'temuduga';
    protected $guarded = ['id'];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class,'kursus_id','id');
    }

    public function ketua()
    {
        return $this->belongsTo(Staff::class,'id_ketua');
    }
}
