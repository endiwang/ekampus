<?php

use App\Actions\Builder\MenuBuilder;

if (! function_exists('menu')) {
    function menu($module, $location)
    {
        return MenuBuilder::build($module, $location)->toArray();
    }
}
