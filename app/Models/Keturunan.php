<?php

namespace App\Models;

use App\Models\Base as Model;

class Keturunan extends Model
{
    protected $table = 'keturunan';

    protected $fillable = ['id', 'kod', 'nama', 'status'];
}
