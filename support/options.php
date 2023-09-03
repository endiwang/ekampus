<?php

if (! function_exists('to_options')) {
    function to_options(array $array): array
    {
        return array_merge([
            '' => __('Any'),
        ], $array);
    }
}
