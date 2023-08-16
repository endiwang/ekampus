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
    <div class="second-header">
        <table style="border: none !important;" width="100%">
            <tbody>
                <tr style="text-align: center; text-transform:uppercase; font-weight:bold;">
                    <td>
                        <p>
                            Jadual Agihan Matapelajaran <br>
                            {{ $program_pengajian->nama ?? null }} Bagi {{ $sesi->nama ?? null }}
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        @foreach ($extracted_datas as $data)
            <table class="table table-bordered report" width="100%" style="margin-bottom: 15px;">
                <thead>
                    <tr>
                        <th>Bil</th>
                        <th>Nama Madah</th>
                        <th>Jam Kredit</th>
                        <th>Semester</th>
                        <th>Kelas - Pensyarah</th>
                    </tr>
                </thead>
                    @php $no = 1 @endphp
                <tbody>
                    @foreach ($data as $lect_data)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $lect_data['subjek'] ?? null}}</td>
                            <td style="text-align: center;">{{ $lect_data['jam_kredit'] ?? null}}</td>
                            <td style="text-align: center;">{{ $lect_data['semester'] ?? null}}</td>
                            <td>{{ $lect_data['kelas'] ?? null}} - {{ $lect_data['pensyarah'] ?? null}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endforeach
    </div>
</html>