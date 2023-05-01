<?php

namespace App\Helpers;

use Carbon\Carbon;
use PDF;
use Illuminate\Support\Facades\App;

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

    public static function formatTime($time)
    {
        $time = Carbon::parse($time)->format('H:i:s A');

        return $time;
    }

    public static function pdfGenerate($title, $datas, $view_file, $paper_orientation)
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView($view_file, compact('datas'))->setPaper('a4', $paper_orientation);
    
        return $pdf->stream($title. '.pdf', array('Attachment'=>0));
    }
}