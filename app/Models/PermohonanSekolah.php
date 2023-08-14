<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanSekolah extends Model
{
    use HasFactory;

    protected $table = 'permohonan_sekolah';

    protected $guarded = ['id'];
}
