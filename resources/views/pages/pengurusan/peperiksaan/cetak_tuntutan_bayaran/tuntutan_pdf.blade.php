<style type="text/css">
    html {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
    }

    .label {
        font-weight: bold;
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
                            DARUL QURAN <br>
                            JABATAN KEMAJUAN ISLAM MALAYSIA
                        </p>
                    </td>
                    <td width="30%" style="text-align: right">
                        <img src="{{ asset('assets/media/logos/logo-dq.png') }}">
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="header">
        <table style="border: none !important;" width="100%">
            <tbody>
                <tr>
                    <td>
                        <hr>
                        <p style="text-align: center;">
                            Ampang Pecah, Kuala Kubu Bahru, 44000 Selangor
                        </p>
                        <hr>
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
                            TUNTUTAN BAYARAN PEPERIKSAAN SEMESTER <br>
                            @if(!empty($pusat_pengajian))
                            PUSAT PEPERIKSAAN : {{ $pusat_pengajian }}<br>
                            @endif
                            @if(!empty($semester))
                            Bagi {{ $program_pengajian->nama }}
                            @endif
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        <table class="table table-bordered report" width="100%">
            <thead>
                <tr>
                    <th rowspan="2">Bil</th>
                    <th rowspan="2">Nama</th>
                    <th rowspan="2">Jantina</th>
                    <th rowspan="2">No. K/P <br> No. Matrik</th>
                    <th rowspan="2">No. Matrik</th>
                    <th rowspan="2">Pengurusan Peperiksaan</th>
                    <th>Jumlah</th>
                </tr>
                <tr>
                    <th colspan="3">RM</th>
                </tr>
            </thead>
                @php $no = 1 @endphp
            <tbody>
                {{-- @forelse ($datas as $data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $data->nama ?? null }}</td>
                        <td style="text-align: center;">{{ $data->jantina ?? null }}</td>
                        <td style="text-align: center;">{{ $data->no_ic ?? null }} <br/>{{ $data->no_matrik ?? null }} </td>
                        <td style="text-align: center;">Semester {{ $data->semester ?? null }}</td>
                        <td style="text-align: center;">{{ $data->syukbah->nama ?? null }}</td>
                        <td style="text-align: center;">0 Subjek</td>
                    </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center">
                        Tiada Data Dijumpai
                    </td>
                </tr>
                @endforelse --}}
            </tbody>
        </table>
    </div>
    <div class="bottom">
        <table class="table table-bordered report" width="100%">
            <thead>
                <tr>
                    <th rowspan="2">Bil</th>
                    <th rowspan="2">Nama Kursus</th>
                    <th rowspan="2">Kod Kursus</th>
                    <th rowspan="2">Jam</th>
                </tr>
            </thead>
                @php $no = 1 @endphp
            <tbody>
                {{-- @forelse ($datas as $data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $data->nama ?? null }}</td>
                        <td style="text-align: center;">{{ $data->jantina ?? null }}</td>
                        <td style="text-align: center;">{{ $data->no_ic ?? null }} <br/>{{ $data->no_matrik ?? null }} </td>
                    </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center">
                        Tiada Data Dijumpai
                    </td>
                </tr>
                @endforelse --}}
            </tbody>
        </table>
    </div>
</html>