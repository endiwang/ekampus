<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bilik extends Model
{
    use HasFactory;

    protected $table = 'bilik';

    protected $guarded = ['id'];
}
