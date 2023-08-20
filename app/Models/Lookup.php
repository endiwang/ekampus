<?php

namespace App\Models;

use App\Models\Base as Model;

class Lookup extends Model
{
    protected $casts = [
        'values' => 'array',
        'is_enabled' => 'boolean',
    ];

    public const CATEGORY_KAUNSELING = 'Kaunseling';

    public static function categories(): array
    {
        return [
            self::CATEGORY_KAUNSELING,
        ];
    }
}
