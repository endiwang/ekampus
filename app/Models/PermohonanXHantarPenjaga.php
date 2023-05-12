<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanXHantarPenjaga extends Model
{
    use HasFactory;
    protected $table = "permohonan_x_hantar_penjaga";
    protected $guarded = ['id'];
}
