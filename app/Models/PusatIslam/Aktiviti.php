<?php

namespace App\Models\PusatIslam;

use App\Models\Base as Model;

class Aktiviti extends Model
{
    protected $table = 'pi_aktiviti';

    protected $routeBaseName = 'pengurusan.hep.pusat-islam.aktiviti';

    protected $casts = [
        'tarikh' => 'date',
        'hari_kebesaran_islam' => 'bool',
    ];
}
