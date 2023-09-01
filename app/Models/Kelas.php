<?php

namespace App\Models;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use SoftDeletes;

    protected $table = 'kelas';

    protected $fillable = ['id', 'nama', 'kapasiti_pelajar', 'semasa_jantina', 'semasa_syukbah_id', 'semasa_semester_id', 'jadual_jantina', 'jadual_syukbah_id', 'jadual_semester_id', 'jumlah_pelajar', 'sesi', 'pusat_pengajian_id', 'is_deleted', 'deleted_by', 'deleted_at'];

    public function currentSemester()
    {
        return $this->belongsTo(Semester::class, 'semasa_semester_id', 'id');
    }

    public function currentSyukbah()
    {
        return $this->belongsTo(Syukbah::class, 'semasa_syukbah_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(Subjek::class, 'kursus_id', 'id');
    }

    public function students()
    {
        return $this->hasMany(Pelajar::class);
    }

    public function jadualKelas()
    {
        return $this->belongsTo(JadualWaktu::class, 'id', 'kelas_id');
    }

    public function pusatPengajian()
    {
        return $this->belongsTo(PusatPengajian::class, 'pusat_pengajian_id', 'id');
    }

    public function getCountPelajarAttribute()
    {
        $count = self::students()->count();

        return $count;
    }

    public function getClassCapacityAttribute()
    {
        return $this->nama.' ['.$this->kapasiti_pelajar.']';
    }
}
