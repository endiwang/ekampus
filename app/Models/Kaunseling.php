<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kaunseling extends Model
{
    use HasFactory;

    protected $table = 'kaunseling';

    protected $guarded = ['id'];

    protected $casts = [
        'tarikh_permohonan' => 'date',
    ];
}
