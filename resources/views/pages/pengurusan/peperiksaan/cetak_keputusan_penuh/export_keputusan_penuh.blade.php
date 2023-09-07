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

    .row {
    margin-left:-5px;
    margin-right:-5px;
    }
    
    .column {
    float: left;
    width: 25%;
    padding: 5px;
    }

    /* Clearfix (clear floats) */
    .row::after {
    content: "";
    clear: both;
    display: table;
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
                            Keputusan Peperiksaan Ini Tertakluk Kepada Keputusan Lembaga Darul Quran <br>
                            @if(!empty($program_pengajian))
                            {{ $program_pengajian }}
                            @endif
                            @if(!empty($pusat_pengajian))
                            - {{ $program_pengajian }}
                            @endif
                            @if(!empty($syukbah))
                            [Syukbah :  {{ $program_pengajian }}]
                            @endif
                            @if(!empty($semester))
                            Bagi {{ $semester }}
                            @endif 
                            @if(!empty($sesi))
                            - {{ $sesi }}
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
                    <th rowspan="2">No. K/P </th>
                    <th rowspan="2">No. Matrik</th>
                    <th rowspan="2"></th>
                    @foreach ($semesterSubjects as $code)
                        <th colspan="4">{{ $code['kod'] }}</th>
                    @endforeach
                    <th rowspan="2">JK</th>
                    <th rowspan="2">JMK</th>
                    <th rowspan="2">PNG</th>
                    <th rowspan="2">JKK</th>
                    <th rowspan="2">JMKK</th>
                    <th rowspan="2">PNGK</th>
                    <th rowspan="2">KEP</th>
                    <th rowspan="2">PGKT</th>
                    <th rowspan="2">JMS</th>
                    <th rowspan="2">JKS</th>
                </tr>
                <tr>
                    @foreach ($semesterSubjects as $code)
                        <th>M</th>
                        <th>P</th>
                        <th>JP</th>
                        <th>G</th>
                    @endforeach
                </tr>
            </thead>
                @php $no = 1 @endphp
            <tbody>
                @forelse ($studentSubjects as $student_subject)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $student_subject['nama'] ?? null }}</td>
                        <td style="text-align: center;">
                            @if($student_subject['jantina'] == 'P')
                            <span style="color:red">(P)</span>
                            @else
                            <span style="color:blue">(L)</span>
                            @endif
                        </td>
                        <td style="text-align: center;">{{ $student_subject['no_ic'] }}</td>
                        <td style="text-align: center;">{{ $student_subject['no_matrik'] }}</td>
                        <td style="text-align: center;">
                            @foreach ($student_subject['data'] as $data)
                                @foreach ($data as $key => $value)
                                    @foreach ($semesterSubjects as $code)
                                        @if($key == $code['kod']) 
                                            <td style="text-align: center;">{{ $value['m'] }}</td>
                                            <td style="text-align: center;">{{ $value['p'] }}</td>
                                            <td style="text-align: center;">{{ $value['jp'] }}</td>
                                            <td style="text-align: center;">{{ $value['g'] }}</td>
                                        @endif
                                    @endforeach
                                @endforeach
                            @endforeach
                        </td>
                        <td style="text-align: center;">{{ $student_subject['jk'] }}</td>
                        <td style="text-align: center;">{{ $student_subject['jmk'] }}</td>
                        <td style="text-align: center;">{{ $student_subject['png'] }}</td>
                        <td style="text-align: center;">{{ $student_subject['jkk'] }}</td>
                        <td style="text-align: center;">{{ $student_subject['jmkk'] }}</td>
                        <td style="text-align: center;">{{ $student_subject['pngk'] }}</td>
                        <td style="text-align: center;">{{ $student_subject['kep'] }}</td>
                        <td style="text-align: center;">{{ $student_subject['pgkt'] }}</td>
                        <td style="text-align: center;">{{ $student_subject['jms'] }}</td>
                        <td style="text-align: center;">{{ $student_subject['jks'] }}</td>
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

    <div class="row">
        <div class="column">
            <table class="table table-bordered report" width="50%">
                <thead>
                    <tr>
                        <th colspan="4">Subjek Kali Pertama</th>
                    </tr>
                    <tr>
                        <th>Bil</th>
                        <th>Nama Kursus</th>
                        <th>Kod Kursus</th>
                        <th>Jam</th>
                    </tr>
                </thead>
                    @php $no = 1 @endphp
                <tbody>
                    @forelse ($semesterSubjects as $subject)
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
        <div class="column">
            <table class="table table-bordered report" width="50%">
                <thead>
                    <tr>
                        <th colspan="3">Gred Kursus Al-Quran</th>
                    </tr>
                    <tr>
                        <th>Gred</th>
                        <th>Mata Nilai</th>
                        <th>Taraf</th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    <tr>
                        <td>A</td>
                        <td>4.0</td>
                        <td>Cemerlang</td>
                    </tr>
                    <tr>
                        <td>B+</td>
                        <td>3.5</td>
                        <td>Kepujian Teratas</td>
                    </tr>
                    <tr>
                        <td>B</td>
                        <td>3.0</td>
                        <td>Kepujian</td>
                    </tr>
                    <tr>
                        <td>C+</td>
                        <td>2.5</td>
                        <td>Lulus</td>
                    </tr>
                    <tr>
                        <td>C</td>
                        <td>2.0</td>
                        <td>Lulus</td>
                    </tr>
                    <tr>
                        <td>F</td>
                        <td>0.0</td>
                        <td>Gagal</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="column">
            <table class="table table-bordered report" width="50%">
                <thead>
                    <tr>
                        <th colspan="3">Gred Kursus Selain Al-Quran</th>
                    </tr>
                    <tr>
                        <th>Gred</th>
                        <th>Mata Nilai</th>
                        <th>Taraf</th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    <tr>
                        <td>A</td>
                        <td>4.0</td>
                        <td>Cemerlang</td>
                    </tr>
                    <tr>
                        <td>B+</td>
                        <td>3.5</td>
                        <td>Kepujian Teratas</td>
                    </tr>
                    <tr>
                        <td>B</td>
                        <td>3.0</td>
                        <td>Kepujian</td>
                    </tr>
                    <tr>
                        <td>C+</td>
                        <td>2.5</td>
                        <td>Lulus</td>
                    </tr>
                    <tr>
                        <td>C</td>
                        <td>2.0</td>
                        <td>Lulus</td>
                    </tr>
                    <tr>
                        <td>F</td>
                        <td>0.0</td>
                        <td>Gagal</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="column">
            <table class="table table-bordered report" width="50%">
                <thead>
                    <tr>
                        <th colspan="2">Status Mata Nilaian</th>
                    </tr>
                    <tr>
                        <th>Mata Nilai</th>
                        <th>Pencapaian</th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    <tr>
                        <td>3.70-4.00</td>
                        <td>MUMTAZ</td>
                    </tr>
                    <tr>
                        <td>3.00-3.74</td>
                        <td>JAYYID JIDDAN</td>
                    </tr>
                    <tr>
                        <td>2.50-2.99</td>
                        <td>JIDDAN</td>
                    </tr>
                    <tr>
                        <td>2.00-2.49</td>
                        <td>MAQBUL</td>
                    </tr>
                    <tr>
                        <td>0.00-1.99</td>
                        <td>RASIB</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="column">
            <table class="table table-bordered report" width="50%">
                <thead>
                    <tr>
                        <th colspan="4">Subjek Ulangan</th>
                    </tr>
                    <tr>
                        <th>Bil</th>
                        <th>Nama Kursus</th>
                        <th>Kod Kursus</th>
                        <th>Jam</th>
                    </tr>
                </thead>
                    @php $no = 1 @endphp
                <tbody>
                    @forelse ($semesterSubjects as $subject)
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
        <div class="column">
            <table class="table table-bordered report" width="50%">
                <thead>
                    <tr>
                        <th>Catatan</th>
                        <th>Taraf</th>
                    </tr>
                </thead>
                <tbody style="text-align: center">
                    <tr>
                        <td>XM</td>
                        <td>Dihalang kerana tidak cukup muqarrar</td>
                    </tr>
                    <tr>
                        <td>XD</td>
                        <td>Dihalang kerana tidak cukup kehadiran</td>
                    </tr>
                    <tr>
                        <td>TD</td>
                        <td>Tarik Diri</td>
                    </tr>
                    <tr>
                        <td>TH</td>
                        <td>Tidak Hadir Tanpa Kebenaran</td>
                    </tr>
                    <tr>
                        <td>TK</td>
                        <td>Tidak Hadir Dengan Kebenaran</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</html>