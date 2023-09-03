<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Yuran extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'yuran';

    protected $guarded = ['id'];
}
