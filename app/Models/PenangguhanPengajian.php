<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenangguhanPengajian extends Model
{
    use HasFactory;

    protected $table = 'penangguhan_pengajian';

    protected $guarded = ['id'];

    public function pelajar()
    {
        return $this->belongsTo(Pelajar::class, 'pelajar_id', 'id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_now_id', 'id');
    }
}
