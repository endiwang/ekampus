<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TawaranPermohonan extends Model
{
    use HasFactory;
    protected $table = 'tawaran_pemohon';
    protected $guarded = ['id'];
}
