<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadualWaktu extends Model
{
    use HasFactory;
    protected $table = 'jadual_waktu';
    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function jadualWaktuDetail()
    {
        return $this->HasMany(JadualWaktuDetail::class, 'jadual_waktu_id', 'id');
    }
}
