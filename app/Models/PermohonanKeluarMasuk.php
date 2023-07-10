<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanKeluarMasuk extends Model
{
    use HasFactory;
    protected $table = "permohonan_keluar_masuk";
    protected $guarded = ['id'];
}
