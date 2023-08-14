<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermohonanSijilTahfiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pelajar_id',
        'masalah_penglihatan',
        'siri_id',
        'pusat_peperiksaan_id',
        'pusat_peperiksaan_negeri_id',
        'nama_tahfiz',
        'alamat_tahfiz',
        'poskod_tahfiz',
        'negeri_tahfiz',
        'jenis_pengajian',
        'tahun_mula',
        'tahun_tamat',
        'tahap_pencapaian_hafazan',
        'status',
        'created_by',
        'is_deleted',
        'deleted_by',
    ];
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
}
