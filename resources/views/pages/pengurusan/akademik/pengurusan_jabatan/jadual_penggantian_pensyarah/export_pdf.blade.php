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
                            Jadual Penggantian Pensyarah <br>
                            Bagi {{ $lecturer->nama ?? null }}
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div>
        
            <table class="table table-bordered report" width="100%" style="margin-bottom: 15px;">
                <thead>
                    <tr>
                        <th>Bil</th>
                        <th>Tarikh</th>
                        <th>Subjek</th>
                        <th>Kelas</th>
                        <th>Masa</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                    @php $no = 1 @endphp
                <tbody>
                    @forelse ($datas as $data)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ Carbon\Carbon::parse($data->tarikh)->format('d/m/Y') ?? null}}</td>
                            <td>{{ $data->subjek->nama ?? null}}</td>
                            <td style="text-align: center;">{{ $data->kelas->nama ?? null}}</td>
                            <td style="text-align: center;">{{ $data->masa_mula ?? null}} - {{ $data->masa_akhir ?? null}}</td>
                            <td>{{ $data->catatan ?? null }}</td>
                        </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center;">Tiada Maklumat</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
       
    </div>
</html>