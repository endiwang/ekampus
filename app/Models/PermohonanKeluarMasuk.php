<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanKeluarMasuk extends Model
{
    use HasFactory;

    protected $table = 'permohonan_keluar_masuk';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pemohon_pelajar_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'pemohon_user_id', 'id');
    }
}
