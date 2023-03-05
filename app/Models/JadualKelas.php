<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadualKelas extends Model
{
    use HasFactory;

    protected $table    = 'jadual_kelas';
    protected $guarded  = ['id'];
}
