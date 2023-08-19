<?php

namespace App\Models;


use App\Models\Base as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeraturanAkademik extends Model
{
    use SoftDeletes;

    protected $table = 'peraturan_akademik';

    protected $guarded = ['id'];
}
