<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PemarkahanCalonSijilTahfiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pemarkahan_calon_sijil_tahfizs';
    protected $guarded = ['id'];
}
