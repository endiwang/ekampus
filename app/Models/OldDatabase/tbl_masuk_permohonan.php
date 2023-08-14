<?php

namespace App\Models\OldDatabase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tbl_masuk_permohonan extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table = 'tbl_masuk_permohonan';
}
