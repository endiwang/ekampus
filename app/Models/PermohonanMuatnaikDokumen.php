<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanMuatnaikDokumen extends Model
{
    use HasFactory;
    protected $table = "permohonan_muat_naik_dokumen";
    protected $guarded = ['id'];
}
