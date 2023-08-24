<style type="text/css">
    html {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
    }


    .timetable {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
    }

    .timetable tr td {
        border: 1px solid black;
        padding: 10px;
    }
    
    .timetable tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .label {
        font-weight: bold;
    }

</style>

<html>
    <div class="header">
        <table style="border: none !important; margin-top:-40px;" width="100%">
            <tbody>
                <tr>
                    <td>
                        <p style="font-weight: bold; font-size: 13px; text-transform:uppercase; text-align:center">Jadual Waktu Bagi {{ $nama->nama ?? null }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
        <table style="border: none !important;" width="100%">
            <tbody>
                <tr>
                    <td>
                        <p style="text-align: left">Semester : {{ $detail->semester->nama ?? null }}</p>
                    </td>
                    <td>
                        <p style="text-align: right">Sesi : {{ $detail->sesi_id ?? null }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        <table class="table table-bordered timetable" width="100%">
            <thead>
                <th width="125">Time</th>
                @foreach($days as $day)
                    <th>{{ $day }}</th>
                @endforeach
            </thead>
            <tbody>
                @foreach($calendarData as $time => $days)
                    <tr>
                        <td>
                            {{ $time }}
                        </td>
                        @foreach($days as $value)
                            @if (is_array($value))
                                <td rowspan="{{ $value['rowspan'] }}" class="align-middle text-center" style="background-color:#f0f0f0; width:15%; text-align:center">
                                    {{ $value['lesson_name'] }}<br>
                                    @if(!empty($value['location']))
                                    Lokasi : {{ $value['location'] }}
                                    @endif
                                </td>
                            @elseif ($value === 1)
                                <td></td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</html>