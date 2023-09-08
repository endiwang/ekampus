<style type="text/css">
    html {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9px;
    }

    #student-details table {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
    }

    #student-details table tr td{
        padding: 5px;
        border: 1px solid black;
    }

    .semester-detail table {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
    }

    .semester-detail table tr td{
        padding: 5px;
        border: 1px solid black;
    }

    .semester-detail table tr th{
        padding: 5px;
        border: 1px solid black;
    }
</style>

<html>
    <head>
        <div class="row">
            <p style="text-align:center; font-size:8px; font-weight:bold;">TRANSKRIP RASMI</p>
        </div>
    </head>

    <body>
        <div style="font-size:9px">
            <div class="row" id="student-details" style="margin-bottom:2px; font-size:8px;">
                <table style="font-weight:bold;width:100%;">
                    <tr>
                        <td style="width:20%;">Nama</td>
                        <td style="width:30%;">{{ ucwords(strtolower($export_data['nama'])) ?? null }}</td>
                        <td style="width:20%;">No. KP</td>
                        <td style="width:30%;">{{ $export_data['ic_no'] ?? null }}</td>
                    </tr>
                    <tr>
                        <td style="width:20%;">Program</td>
                        <td style="width:30%;"> {{ ucwords(strtolower($export_data['program'])) ?? null }}</td>
                        <td style="width:20%;">No. Matrik</td>
                        <td style="width:30%;"> {{ ucwords(strtolower($export_data['no_matrik'])) ?? null }}</td>
                    </tr>

                    <tr>
                        <td style="width:20%;">Syukbah</td>
                        <td style="width:30%;"> {{ $export_data['syukbah'] ?? null }}</td>
                        <td style="width:20%;">Sesi</td>
                        <td style="width:30%;"> {{ ucwords(strtolower($export_data['sesi'])) ?? null }}</td>
                    </tr>
                </table>
            </div>

            @foreach($export_data['data'] as $data)
                <div class="row" id="student_result" style="margin-bottom:2px; font-size:8px;">
                    <div class="row">
                        <table style="width:100%;">
                            <tbody>
                                <tr>
                                    <td style="width:100%;">
                                        <div class="row" class="semester-detail" style="margin-bottom:2px; font-size:8px;">
                                            <table>
                                                <tr>
                                                    <td>
                                                        SESI
                                                    </td>
                                                    <td>
                                                        {{$data['sesi'] ?? null}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        SEMESTER
                                                    </td>
                                                    <td>
                                                        {{$data['semester'] ?? null}}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="row" class="semester-detail" style="font-size:8px;">
                                        <table style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th style="text-transform:uppercase; font-weight:bold; width:20%">Kod</th>
                                                    <th style="text-transform:uppercase; font-weight:bold; width:40%">Subjek</th>
                                                    <th style="text-transform:uppercase; font-weight:bold; width:20%">Gred</th>
                                                    <th style="text-transform:uppercase; font-weight:bold; width:20%">Mata</th>
                                                </tr>
                                            </thead>
                                            
                                            <tbody>
                                                @foreach($data['transcript_datas'] as $transcript)
                                                    <tr>
                                                        <td>{{ $transcript->subjek->kod_subjek ?? null }}</td>
                                                        <td>{{ $transcript->subjek->nama ?? null }}</td>
                                                        <td style="text-align: center">{{ $transcript->gred ?? null }}</td>
                                                        <td style="text-align: center">{{ $transcript->pointer ?? null }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        </div>
                                        <div class="row" class="semester-detail" style="margin-bottom:2px; font-size:8px;">
                                            <table>
                                                <tr>
                                                    <td>
                                                        PNGS
                                                    </td>
                                                    <td style="text-align:center">
                                                        {{$data['pngs'] ?? null}}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        PNGK
                                                    </td>
                                                    <td style="text-align:center">
                                                        {{$data['pngk'] ?? null}}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                               
                            </tbody>
                        </table> 
                    </div>
                </div>
            @endforeach

            <div class="row">
                <table class="table" width="100%" style="font-size: 9px;">
                    <tr>
                        <td colspan="2" align="center" class="data"><br /><br /><br />
                            KEPUTUSAN : <u><b>{{ $export_data['program'] ?? null }}</b></u> &nbsp;&nbsp;PNGK : <u><b>{{ $export_data['pngk'] ?? null }}</b></u><br />
                            @if( $export_data['pangkat_code'] == 'R')
                                 TIDAK LAYAK DIANUGERAHKAN {{ $export_data['program'] ?? null }}</b></u>
                            @else
                                LAYAK DIANUGERAHKAN {{ $export_data['program'] ?? null }} DENGAN KEPUTUSAN : <u><b>{{ strtoupper($export_data['pangkat']) ?? null }}</b></u>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="row">
                <table class="table" width="100%" style="margin-top: 20px;"> 
                    <tr height="120">
                        <td width="50%" valign="bottom" class="data">
                        .............................................<br />
                        Pengarah Darul Quran<br />
                        Jabatan Kemajuan Islam Malaysia
                        </td>
                        <td width="50%" valign="bottom" class="data">
                            Dikeluarkan Pada : 
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </body>
</html>