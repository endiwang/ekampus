<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanTanggunganPenjaga extends Model
{
    use HasFactory;

    protected $table = 'permohonan_tanggungan_penjaga';

    protected $guarded = ['id'];
}
