<?php

namespace App\Models;


use App\Models\Base as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pelajar extends Model
{
    use SoftDeletes;

    protected $table = 'pelajar';

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

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }

    public function syukbah()
    {
        return $this->belongsTo(Syukbah::class, 'syukbah_id', 'id');
    }

    public function negeri()
    {
        return $this->belongsTo(Negeri::class, 'negeri_id', 'id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester', 'id');
    }

    public function getNameIcAttribute()
    {
        return ucfirst($this->nama).' - '.ucfirst($this->no_ic);
    }
}
