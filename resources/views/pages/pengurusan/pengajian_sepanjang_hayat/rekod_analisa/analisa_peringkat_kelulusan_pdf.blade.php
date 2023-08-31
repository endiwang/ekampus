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
                            Analisa Peringkat Kelulusan
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
                    <th>Peringkat Kelulusan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
                @php 
                    $no = 1;
                    $mumtaz = 0;
                    $jayyid_jiddan = 0;
                    $jayyid = 0;
                    $maqbul = 0;
                    $rasib = 0;
                @endphp
            <tbody>
                @forelse ($datas as $key => $value)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $key }}</td>
                    <td>{{ $value }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center">
                        Tiada Data Dijumpai
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</html>