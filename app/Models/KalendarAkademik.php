<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KalendarAkademik extends Model
{
    use HasFactory;

    protected $table = 'kalendar_akademik';

    protected $guarded = ['id'];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'program_id', 'id');
    }
}
