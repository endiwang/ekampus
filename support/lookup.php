<?php

use App\Models\Lookup;
use Illuminate\Support\Facades\Cache;

if (! function_exists('lookup')) {
    function lookup(string $category, string $key, int $ttl = 60, bool $is_enabled = true)
    {
        return Cache::remember(
            "lookup.{$category}.{$key}.{$ttl}",
            $ttl,
            fn () => Lookup::query()
                ->where('key', $key)
                ->where('category', $category)
                ->where('is_enabled', $is_enabled)
                ->get()
        );
    }
}

if (! function_exists('lookup_kaunseling')) {
    function lookup_kaunseling(string $key)
    {
        return lookup(Lookup::CATEGORY_KAUNSELING, $key);
    }
}
