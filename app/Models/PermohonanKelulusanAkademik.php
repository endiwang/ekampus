<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanKelulusanAkademik extends Model
{
    use HasFactory;
    protected $table = "permohonan_kelulusan_akademik";
    protected $guarded = ['id'];
}
