<?php

namespace App\Models\oldDatabase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sis_jadbilik extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';
    protected $table = '_sis_jadbilik';
}
