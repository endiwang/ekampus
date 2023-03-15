<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gred extends Model
{
    use HasFactory;

    protected $table = 'gred';
    protected $guarded = ['id'];
}
