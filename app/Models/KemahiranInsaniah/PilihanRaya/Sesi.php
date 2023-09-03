<?php

namespace App\Models\KemahiranInsaniah\PilihanRaya;

use App\Models\Base as Model;

class Sesi extends Model
{
    protected $table = 'pr_sesi';

    protected $casts = [
        'fasal_2' => 'array',
        'fasal_3' => 'array',
        'tarikh_penamaan_calon' => 'date',
        'tarikh_mengundi' => 'date',
    ];
}
