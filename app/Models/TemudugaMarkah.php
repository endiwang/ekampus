<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemudugaMarkah extends Model
{
    use HasFactory;
    protected $table = 'temuduga_markah';
    protected $guarded = ['id'];


    public function pemohon()
    {
        return $this->belongsTo(Permohonan::class,'permohonan_id');
    }
}
