<?php

namespace App\Models;

use App\Models\Base as Model;

class Lookup extends Model
{
    protected $casts = [
        'values' => 'array',
    ];

    public const CATEGORY_KAUNSELING = 'Kaunseling';
}
