<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PeraturanAkademik extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "peraturan_akademik";
    protected $guarded = ['id'];

}
