<?php

use App\Models\Lookup;
use Illuminate\Support\Facades\Cache;

if (! function_exists('lookup')) {
    function lookup(string $key, int $ttl = 60)
    {
        return Cache::remember(
            'lookup.'.$key,
            $ttl,
            fn () => Lookup::where('key', $key)->get()
        );
    }
}
