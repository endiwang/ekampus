<?php

namespace App\Helpers;

use Carbon\Carbon;
use PDF;

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

    public static function pdfGenerate($title, $datas, $view_file)
    {
        $pdf = PDF::loadView($view_file, $datas)->setPaper('a4', 'potrait');

        return $pdf->stream($title. '.pdf');
    }
}