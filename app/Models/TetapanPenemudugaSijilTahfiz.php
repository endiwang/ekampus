<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TetapanPenemudugaSijilTahfiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tetapan_penemuduga_sijil_tahfizs';
    protected $guarded = ['id'];

    public function staff(){
        return $this->belongsTo(Staff::class);
    }
}
