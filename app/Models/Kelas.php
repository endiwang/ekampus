<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kelas extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kelas';
    protected $fillable = ['id','nama','kapasiti_pelajar','semasa_jantina','semasa_syukbah_id','semasa_semester_id','jadual_jantina','jadual_syukbah_id','jadual_semester_id','jumlah_pelajar','sesi','pusat_pengajian_id','is_deleted','deleted_by','deleted_at'];


}
