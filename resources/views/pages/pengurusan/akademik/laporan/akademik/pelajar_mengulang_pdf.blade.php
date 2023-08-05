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
                            Senarai Pelajar Mengulang (Semester) <br>
                            @if(!empty($sesi))
                            Sesi Peperiksaan <br>
                            @endif
                            @if(!empty($program_pengajian))
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
                    <th>Bil</th>
                    <th>Nama</th>
                    <th>Jantina</th>
                    <th>No. K/P <br> No. Matrik</th>
                    <th>Subjek</th>
                </tr>
            </thead>
                @php $no = 1 @endphp
            <tbody>
                @forelse ($datas as $data)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>
                            {{ $data->nama ?? null }} <br/>
                            Semester : {{ $data->semester }} <br/>
                            @if(!empty($data->syukbah))
                            Syukbah : {{ $data->syukbah->nama ?? null }} [ {{ $data->jam_kredi ?? 0}} / {{ $data->syukbah->jumlah_jam_kredit ?? 0}} ]
                            @else
                            Syukbah : Tiada Maklumat
                            @endif
                        </td>
                        <td style="text-align: center;">{{ $data->jantina ?? null }}</td>
                        <td style="text-align: center;">{{ $data->no_ic ?? null }} <br/>{{ $data->no_matrik ?? null }} </td>
                        <td style="text-align: center;">0 Subjek</td>
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