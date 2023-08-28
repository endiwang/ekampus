<?php

namespace App\Helpers;

use App\Models\Notifikasi;
use App\Models\SemesterTerkini;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;

class Utils
{
    public static function formatDate($date)
    {
        $date = Carbon::parse($date)->format('d/m/Y');

        return $date;
    }

    public static function formatDate2($date)
    {
        $date = Carbon::parse($date)->format('d-m-Y');

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

    public static function formatMonth($date)
    {
        $time = Carbon::parse($date)->format('m-Y');

        return $time;
    }

    public static function pdfGenerate($title, $datas, $view_file, $paper_orientation)
    {
        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView($view_file, compact('datas'))->setPaper('a4', $paper_orientation);

        return $pdf->stream($title.'.pdf', ['Attachment' => 0]);
    }

    public static function days()
    {
        $days = [
            1 => 'Isnin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Khamis',
            5 => 'Jumaat',
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

    public static function notify($notify_to, $description)
    {
        $notify = new Notifikasi();
        $notify->sent_to = $notify_to;
        $notify->description = $description;
        $notify->save();
    }

    public static function getCurrenSemester($kursus_id)
    {
        $sem_now = SemesterTerkini::select('id', 'kursus_id', 'semester_no', 'sesi_pengajian', 'sesi')
                    ->where('status_semester', 0)
                    ->where('kursus_id', $kursus_id)
                    ->first();

        return $sem_now;
    }

    public static function getPointer($mark)
    {
        if($mark>=80){
            $pointer=4.0;
        } else if($mark>=70 && $mark<=79){
            $pointer=3.5;
        } else if($mark>=60 && $mark<=69){
            $pointer=3.0;
        } else if($mark>=55 && $mark<=59){
            $pointer=2.5;
        } else if($mark>=50 && $mark<=54){
            $pointer=2.0;
        } else if($mark>=45 && $mark<=49){
            $pointer=1.5;
        } else if($mark>=40 && $mark<=44){
            $pointer=1.0;
        } else if($mark<=39){
            $pointer=0;
        }

        return $pointer;
    }
}
