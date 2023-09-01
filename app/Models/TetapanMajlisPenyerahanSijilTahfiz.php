<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TetapanMajlisPenyerahanSijilTahfiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tetapan_majlis_penyerahan_sijil_tahfizs';
    protected $guarded = ['id'];
}
