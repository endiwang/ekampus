<?php

namespace App\Models\OldDatabase;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sis_tbltawaran_mohon extends Model
{
    use HasFactory;

    protected $connection = 'mysql2';

    protected $table = '_sis_tbltawaran_mohon';
}
