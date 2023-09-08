<?php

namespace App\Models\PusatIslam;

use App\Models\Base as Model;

class JadualTugasan extends Model
{
    protected $table = 'pi_jadual_tugasan';

    protected $casts = [
        'imam' => 'array',
        'bilal' => 'array',
    ];
}
