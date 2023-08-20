<?php

namespace App\Models;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sesi extends Model
{
    use SoftDeletes;

    protected $table = 'sesi';

    protected $fillable = ['id', 'nama', 'kursus_id', 'status', 'tarikh_akhir_exam', 'tarikh_transkrip', 'order', 'tahun_bermula', 'tahun_berakhir', 'is_deleted', 'deleted_by'];

    public function pelajar()
    {
        return $this->hasMany(Pelajar::class)->where('is_deleted', 0)->where('is_berhenti', 0)->where('is_register', 1);
    }

    public function kursus()
    {
        return $this->belongsTo(Kursus::class, 'kursus_id', 'id');
    }
}
