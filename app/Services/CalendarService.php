<?php

namespace App\Services;

use App\Models\JadualPensyarahDetail;
use App\Models\JadualWaktuDetail;

class CalendarService
{
    public function generateCalendarData($weekDays, $id)
    {
        $calendarData = [];
        $timeRange = (new TimeService)->generateTimeRange(config('app.calendar.start_time'), config('app.calendar.end_time'));
        $lessons = JadualWaktuDetail::with('subjek', 'staff')->where('jadual_waktu_id', $id)->get();

        foreach ($timeRange as $time) {
            $timeText = $time['start'].' - '.$time['end'];
            $calendarData[$timeText] = [];

            foreach ($weekDays as $index => $day) {
                $lesson = $lessons->where('hari', $index)->where('masa_mula', $time['start'])->first();

                if ($lesson) {
                    array_push($calendarData[$timeText], [
                        'lesson_name' => $lesson->subjek->nama,
                        'teacher_name' => $lesson->staff->nama ?? null,
                        'rowspan' => $lesson->difference / 30 ?? '',
                        'location' => $lesson->lokasi ?? null,
                    ]);
                } elseif (! $lessons->where('hari', $index)->where('masa_mula', '<', $time['start'])->where('masa_akhir', '>=', $time['end'])->count()) {
                    array_push($calendarData[$timeText], 1);
                } else {
                    array_push($calendarData[$timeText], 0);
                }
            }
        }

        return $calendarData;
    }

    public function generateLecturerCalendarData($weekDays, $id)
    {
        $calendarData = [];
        $timeRange = (new TimeService)->generateTimeRange(config('app.calendar.start_time'), config('app.calendar.end_time'));
        $lessons = JadualPensyarahDetail::with('subjek')->where('jadual_pensyarah_id', $id)->get();

        foreach ($timeRange as $time) {
            $timeText = $time['start'].' - '.$time['end'];
            $calendarData[$timeText] = [];

            foreach ($weekDays as $index => $day) {
                $lesson = $lessons->where('hari', $index)->where('masa_mula', $time['start'])->first();

                if ($lesson) {
                    array_push($calendarData[$timeText], [
                        'lesson_name' => $lesson->subjek->nama,
                        'rowspan' => $lesson->difference / 30 ?? '',
                        'location' => $lesson->lokasi ?? null,
                    ]);
                } elseif (! $lessons->where('hari', $index)->where('masa_mula', '<', $time['start'])->where('masa_akhir', '>=', $time['end'])->count()) {
                    array_push($calendarData[$timeText], 1);
                } else {
                    array_push($calendarData[$timeText], 0);
                }
            }
        }

        return $calendarData;
    }
}
