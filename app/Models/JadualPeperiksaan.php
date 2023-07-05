<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadualPeperiksaan extends Model
{
    use HasFactory;
    protected $table = 'jadual_peperiksaan';
    protected $guarded = ['id'];
}
