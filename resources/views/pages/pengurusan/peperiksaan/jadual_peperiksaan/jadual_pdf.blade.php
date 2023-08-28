<style type="text/css">
    html {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 11px;
    }

    .label {
        font-weight: bold;
    }

    #timetable-details {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
    }

    .report {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
    }

    .report tr th {
        border: 1px solid black;
        padding: 5px;
    }

    .report tr td {
        border: 1px solid black;
        padding: 10px;
    }
    
    .report tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    hr {
        border : 1px solid black;
    }

</style>

<html>
    <div class="header">
        <table style="border: none !important; margin-top:-40px;" width="100%">
            <tbody>
                <tr>
                    <td style="text-align: right">
                        Dijana pada : {{ $generated_at }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="header">
        <table style="border: none !important; margin-top:-20px;" width="100%">
            <tbody>
                <tr>
                    <td width="30%">
                        <img src="{{ asset('assets/media/logos/crestmalaysia.gif') }}">
                    </td>
                    <td>
                        <p style="font-weight: bold; font-size: 15px; text-transform:uppercase; text-align:center">
                            Darul Quran <br>
                            Jabatan Kemajuan Islam Malaysia
                        </p>
                    </td>
                    <td width="30%" style="text-align: right">
                        <img src="{{ asset('assets/media/logos/logo-dq.png') }}">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="second-header">
        <table style="border: none !important;" width="100%">
            <tbody>
                <tr style="text-align: center; text-transform:uppercase; font-weight:bold;">
                    <td>
                        <p>
                            Jadual Peperiksaan
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row" id="timetable-details" style="margin-bottom:2px;">
        <table style="font-weight:bold;width:100%;">
            <tr>
                <td style="width:20%;">Program Pengajian</td>
                <td style="width:30%;">: {{ $detail->kursus->nama ?? null }}</td>
                <td style="width:20%;">Pusat Pengajian</td>
                <td style="width:30%;">: {{ $detail->pusat_pengajian->nama ?? null }}</td>
            </tr>
            <tr>
                <td style="width:20%;">Syukbah</td>
                <td style="width:30%;">: {{ $detail->syukbah->nama ?? null }}</td>
                <td style="width:20%;">Sesi</td>
                <td style="width:30%;">: {{ $detail->sesi->nama ?? null }}</td>
            </tr>
            <tr>
                <td style="width:20%;">Semester</td>
                <td style="width:30%;">: {{ $detail->semester->nama ?? null }}</td>
                <td style="width:20%;"></td>
                <td style="width:30%;"></td>
            </tr>
        </table>
    </div>
    <div>
        <table class="table table-bordered report" width="100%" style="margin-bottom: 15px;">
            <thead>
                <tr>
                    <th>Bil</th>
                    <th>Subjek</th>
                    <th>Tarikh</th>
                    <th>Masa</th>
                    <th>Lokasi</th>
                </tr>
            </thead>
            @php $no = 1 @endphp
            <tbody>
                @foreach ($jadual_peperiksaan as $data)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $data->subjek->nama ?? null}}</td>
                    <td style="text-align: center;">{{ $data->tarikh ?? null}}</td>
                    <td style="text-align: center;">{{ $data->masa ?? null}} - {{ $data->masa_akhir ?? null}}</td>
                    <td>{{ $data->lokasi ?? null}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</html>