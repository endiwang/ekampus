<?php

namespace App\Models\OldDatabase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ref_asrama_blok extends Model
{
    use HasFactory;
    protected $connection = 'mysql2';
    protected $table = 'ref_asrama_blok';
}
