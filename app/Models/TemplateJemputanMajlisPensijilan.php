<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateJemputanMajlisPensijilan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'template_jemputan_majlis_pensijilans';
    protected $guarded = ['id'];

    public function majlis(){
        return $this->belongsTo(TetapanMajlisPenyerahanSijilTahfiz::class,'majlis_id', 'id');
    }
}
