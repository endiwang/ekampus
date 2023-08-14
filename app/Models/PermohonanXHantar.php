<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermohonanXHantar extends Model
{
    use HasFactory;

    protected $table = 'permohonan_x_hantar';

    protected $guarded = ['id'];
}
