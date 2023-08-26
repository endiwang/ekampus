<?php

namespace App\Actions\Builder;

class MenuBuilder
{
    public static function build($module, $location)
    {
        $menu = collect(config('menu.'.$module.'.'.$location));

        return $menu->map(function ($item) use ($module) {
            $item['module'] = $module;
            $item['active'] = self::isActive($item);
            $item['route'] = $item['route'] ?? null;

            return $item;
        });
    }

    private static function isActive($item)
    {
        if (isset($item['active'])) {
            return $item['active'];
        }

        if (isset($item['route'])) {
            return request()->routeIs($item['route']);
        }

        return false;
    }
}
