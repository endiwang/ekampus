<?php

namespace App\Models\PusatIslam;

use App\Models\Base as Model;

class JadualTugasan extends Model
{
    protected $table = 'pi_jadual_tugasan';

    protected $urlPrefix = 'pengurusan.hep.pusat-islam.';

    protected $casts = [
        'tarih' => 'date',
        'user' => 'array',
        'is_subuh' => 'bool',
        'is_zohor' => 'bool',
        'is_asar' => 'bool',
        'is_magrhib' => 'bool',
        'is_isyak' => 'bool',
    ];
}
