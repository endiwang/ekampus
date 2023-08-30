<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TemplateSijilTahfiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'template_sijil_tahfizs';
    protected $guarded = ['id'];
}
