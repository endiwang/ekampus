<?php

namespace App\Helpers;

use Carbon\Carbon;

class Utils
{
    public static function formatDate($date)
    {
        $date = Carbon::parse($date)->format('d/m/Y');

        return $date;
    }

    public static function formatDateTime($date)
    {
        $date = Carbon::parse($date)->format('d/m/Y H:i:s A');

        return $date;
    }
}