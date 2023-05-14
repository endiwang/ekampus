<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadualWaktu extends Model
{
    use HasFactory;
    protected $table = 'jadual_waktu';
    protected $guarded = ['id'];
}
