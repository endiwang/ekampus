<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class YuranDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'yuran_detail';

    protected $guarded = ['id'];
}
