<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Subjek extends Model
{
    use HasFactory;
    use HasFactory, SoftDeletes;
    protected $table = 'subjek';
    protected $fillable = ['id','nama','kursus_id','status','kod_subjek','maklumat_tambahan','kredit','jumlah_markah','is_alquran','is_calc','is_print','type','nama_arab','sort','is_deleted','deleted_by','deleted_at'];
}
