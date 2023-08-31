<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermohonanSijilTahfiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'permohonan_sijil_tahfizs';
    protected $guarded = ['id'];

    public function permohonanSijilTahfizFile(){
        return $this->hasMany(PermohonanSijilTahfizFile::class);
    }

    public function tetapanSiriPeperiksaan(){
        return $this->belongsTo(TetapanPeperiksaanSijilTahfiz::class, 'siri_id', 'id');
    }

    public function pelajar(){
        return $this->belongsTo(Pelajar::class);
    }

    public function pusatPeperiksaan(){
        return $this->belongsTo(PusatPeperiksaan::class);
    }

    public function pusatPeperiksaanNegeri(){
        return $this->belongsTo(PusatPeperiksaanNegeri::class);
    }

    public function markahPermohonan(){
        return $this->belongsTo(PemarkahanCalonSijilTahfiz::class, 'id', 'permohonan_id');
    }

    public function pemohon(){
        return $this->belongsTo(Pemohon::class);
    }

    public function templateJemputan(){
        return $this->belongsTo(TemplateJemputanMajlisPensijilan::class,'template_id', 'id');
    }

    public function pemarkahans(){
        return $this->hasMany(PemarkahanCalonSijilTahfiz::class, 'id', 'permohonan_id');
    }
}
