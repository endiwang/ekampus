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

    public const CATEGORY_PUSAT_ISLAM = 'Pusat Islam';

    public const CATEGORY_KEMAHIRAN_INSANIAH = 'Kemahiran Insaniah';

    public static function categories(): array
    {
        return [
            self::CATEGORY_KAUNSELING,
            self::CATEGORY_PUSAT_ISLAM,
        ];
    }
}
