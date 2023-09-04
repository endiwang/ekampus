<?php

namespace App\Models;

use App\Models\Base as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengambilanSijilTahfiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'pengambilan_sijil_tahfizs';

    protected $guarded = ['id'];
}
