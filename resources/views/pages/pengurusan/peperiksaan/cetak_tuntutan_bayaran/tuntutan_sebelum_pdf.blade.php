<style type="text/css">
    html {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
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
                            @if(!empty($pusat_peperiksaan))
                            PUSAT PEPERIKSAAN : {{ $pusat_peperiksaan }}<br>
                            @endif
                            @if(!empty($semester))
                            {{ $semester }}
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
                    <th rowspan="3">Bil</th>
                    <th rowspan="3">Nama</th>
                    <th rowspan="3">Jantina</th>
                    <th rowspan="3">No. K/P</th>
                    <th rowspan="3">No. Matrik</th>
                    <th colspan="{{ $size_subject }}"></th>
                    <th rowspan="2">Pengurusan Peperiksaan</th>
                    <th rowspan="2">Jumlah</th>
                </tr>
                <tr>
                    @foreach ($subject_codes as $code)
                        <th>{{ $code['kod'] }}</th>
                    @endforeach
                    
                </tr>
                <tr>
                    @foreach ($subject_codes as $code)
                    <th>RM</th>
                    @endforeach
                    <th>RM</th>
                    <th>RM</th>
                </tr>
            </thead>
                @php $no = 1 @endphp
            <tbody>
                @forelse ($subject_datas as $student_data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $student_data['nama'] ?? null }}</td>
                        <td style="text-align: center;">
                            @if($student_data['jantina'] == 'P')
                            <span style="color:red">({{ $student_data['jantina'] ?? null }})</span>
                            @else
                            <span style="color:blue">({{ $student_data['jantina'] ?? null }})</span>
                            @endif
                        </td>
                        <td style="text-align: center;">{{ $student_data['no_ic'] ?? null }}</td>
                        <td style="text-align: center;">{{ $student_data['no_matrik'] ?? null }} </td>
                        @foreach ($student_data['data'] as $rate)
                            @foreach ($rate as $key => $value)
                                @foreach ($subject_codes as $code)
                                    @if($key == $code['kod']) 
                                        <td style="text-align: center;">{{ $value ?? '0.00'}}</td>
                                    @endif
                                @endforeach
                            @endforeach
                        @endforeach
                        <td style="text-align: center;">{{ $student_data['pengurusan_peperiksaan'] ?? null }}</td>
                        <td style="text-align: center;">{{ $student_data['jumlah'] }}</td>
                    </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center">
                        Tiada Data Dijumpai
                    </td>
                </tr>
                @endforelse --}}
                <tr>
                    <td colspan="{{ $overall_col_size }}" style="text-align: right; font-weight: bold;">JUMLAH</td>
                    <td><b>{{ $overall_total }}</b></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="bottom" style="margin-top: 10px;">
        <table class="table table-bordered report" width="50%">
            <thead>
                <tr>
                    <th>Bil</th>
                    <th>Nama Kursus</th>
                    <th>Kod Kursus</th>
                    <th>Jam</th>
                </tr>
            </thead>
                @php $no = 1 @endphp
            <tbody>
                @forelse ($subject_codes as $subject)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $subject['nama'] ?? null }}</td>
                        <td style="text-align: center;">{{ $subject['kod'] ?? null }}</td>
                        <td style="text-align: center;">{{ $subject['jam_kredit'] ?? null }}</td>
                    </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center">
                        Tiada Data Dijumpai
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</html>