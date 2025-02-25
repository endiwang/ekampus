<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TetapanPeperiksaan extends Model
{
    use HasFactory;

    protected $table = 'tetapan_peperiksaan';

    protected $guarded = ['id'];

    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi_id', 'id');
    }

    public function pusat_pengajian()
    {
        return $this->belongsTo(PusatPengajian::class, 'pusat_pengajian_id', 'id');
    }

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'kursus_id', 'id');
    }

    public function syukbah()
    {
        return $this->belongsTo(Syukbah::class, 'syukbah_id', 'id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id', 'id');
    }
}
