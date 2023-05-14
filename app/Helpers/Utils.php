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

    public static function formatTime2($time)
    {
        $time = Carbon::parse($time)->format('H:i A');

        return $time;
    }

    public static function pdfGenerate($title, $datas, $view_file, $paper_orientation)
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView($view_file, compact('datas'))->setPaper('a4', $paper_orientation);
    
        return $pdf->stream($title. '.pdf', array('Attachment'=>0));
    }

    public static function days()
    {
        $days = [
            1 => 'Isnin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Khamis',
            5 => 'Jumaat',
            6 => 'Sabtu',
            7 => 'Ahad'
        ];

        return $days;
    }

    public static function times()
    {
        $times = [
            '8.00' => '8.00 Pagi',
            '9.00' => '9.00 Pagi',
            '10.00' => '10.00 Pagi',
            '11.00' => '11.00 Pagi',
            '12.00' => '12.00 Tengahari',
            '13.00' => '1.00 Petang',
            '14.00' => '2.00 Petang',
            '15.00' => '3.00 Petang',
            '16.00' => '4.00 Petang',
            '17.00' => '5.00 Petang',
            '18.00' => '6.00 Petang',
        ];

        return $times;
    }
}