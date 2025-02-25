<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CloPlo extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function clo()
    {
        return $this->belongsTo(Clo::class, 'clo_id', 'id');
    }

    public function plo()
    {
        return $this->belongsTo(Plo::class, 'plo_id', 'id');
    }

    public function pensyarah()
    {
        return $this->belongsTo(Staff::class, 'pensyarah_id', 'id');
    }

    public function subjek()
    {
        return $this->belongsTo(Subjek::class, 'kursus_id', 'id');
    }

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'program_pengajian_id', 'id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }
}
