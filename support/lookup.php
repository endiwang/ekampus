<?php

use App\Models\Lookup;
use Illuminate\Support\Facades\Cache;

if (! function_exists('lookup')) {
    function lookup(string $category, string $key, int $ttl = 60)
    {
        return Cache::remember(
            "lookup.{$category}.{$key}.{$ttl}",
            $ttl,
            fn () => Lookup::where('key', $key)->where('category', $category)->get()
        );
    }
}
