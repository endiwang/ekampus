<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IjazahLatihanIndustri extends Model
{
    use HasFactory;

    protected $table = 'ijazah_latihan_industri';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'id');
    }
}
