<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Syukbah extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'syukbah';
    protected $fillable = ['id','nama','kuota_pelajar','jumlah_jam_kredit','kursus_id','status'];
}
