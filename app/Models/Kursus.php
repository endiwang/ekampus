<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Kursus extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'kursus';
    protected $fillable = ['id','kod','nama','nama_arab','status','bil_sem_keseluruhan','bil_sem_setahun','pusat_pengajian_id','is_deleted','deleted_by','deleted_at'];
}
