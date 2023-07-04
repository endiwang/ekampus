<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plo extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function subjek()
    {
        return $this->belongsTo(Subjek::class,'subjek_id','id');
    }

    public function kursus()
    {
        return $this->belongsTo(Kursus::class,'program_pengajian_id','id');
    }
}
