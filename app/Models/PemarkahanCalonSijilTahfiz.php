<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemarkahanCalonSijilTahfiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pemarkahan_calon_sijil_tahfizs';
    protected $guarded = ['id'];

    public function permohonanSijilTahfiz(){
        return $this->belongsTo(PermohonanSijilTahfiz::class, 'permohonan_id', 'id');
    }

    public function pelajar(){
        return $this->belongsTo(Pelajar::class);
    }

    public function pemohon(){
        return $this->belongsTo(Pemohon::class);
    }

    public function permohonan(){
        return $this->belongsTo(Permohonan::class);
    }
}
