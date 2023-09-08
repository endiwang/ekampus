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
                            [Syukbah :  {{ $syukbah }}]
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
                    <th>Bil</th>
                    <th>Nama</th>
                    <th>Jantina</th>
                    <th>No. K/P </th>
                    <th>No. Matrik</th>
                    <th>PNG</th>
                    <th>PNGK</th>
                    <th>KEP</th>
                    <th>PGKT</th>
                </tr>
            </thead>
                @php $no = 1 @endphp
            <tbody>
                @forelse ($data as $value)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $value->pelajar->nama ?? null }} </td>
                        <td style="text-align: center;">
                            @if($value->pelajar->jantina == 'L')
                                <span style="color:blue">(L)</span>
                            @else
                                <span style="color:red">(P)</span>
                            @endif
                        </td>
                        <td style="text-align: center;">{{ $value->pelajar->no_ic ?? null }}</td>
                        <td style="text-align: center;">{{ $value->pelajar->no_matrik ?? null }}</td>
                        <td style="text-align: center;">{{ number_format($value->png,2) ?? null }}</td>
                        <td style="text-align: center;">{{ number_format($value->pngk,2) ?? null }}</td>
                        <td style="text-align: center;">{{ $value->keputusan ?? null }}</td>
                        <td style="text-align: center;">{{ $value->pangkat ?? null}}</td>
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