<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PelepasanKuliah extends Model
{
    use HasFactory;
    protected $table = 'pelepasan_kuliah';
    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class,'user_id','user_id');
    }
}
