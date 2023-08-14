<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TetapanPermohonanPelajar extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tetapan_permohonan_pelajar';

    protected $fillable = [
        'id',
        'kursus_id',
        'sesi_id',
        'status_ujian',
        'status',
        'mula_permohonan',
        'tutup_permohonan',
        'tutup_pendaftaran',
        'mula_semakan_temuduga',
        'tutup_semakan_temuduga',
        'tajuk_semakan_temuduga',
        'maklumat_semakan_temuduga',
        'mula_semakan_tawaran',
        'tutup_semakan_tawaran',
        'tutup_rayuan',
        'tajuk_semakan_rayuan',
        'mula_semakan_rayuan',
        'tutup_semakan_rayuan',
        'tajuk_semakan_tawaran',
        'maklumat_semakan_tawaran',
        'pusat_temuduga',
        'is_deleted',
        'deleted_by',
        'deleted_at',
    ];

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'kursus_id', 'id');
    }

    public function sesi()
    {
        return $this->belongsTo(Sesi::class, 'sesi_id', 'id');
    }

    public function pusat_pengajian()
    {
        return $this->belongsTo(PusatPengajian::class, 'pusat_pengajian_id', 'id');
    }

    public function getPusatTemudugaAttribute($value)
    {
        if ($value != null) {
            $data = PusatTemuduga::whereIn('id', json_decode($value))->pluck('nama', 'id');

            return json_decode($data);

        } else {
            return '';
        }

    }
}
