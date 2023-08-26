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

    table, th, td {
        vertical-align: top;
        text-align: left;
    }

</style>

<html>
    <div class="header">
        <table style="border: none !important; margin-top:-40px;" width="100%">
            <tbody>
                <tr>
                    <td style="text-align: right">
                        Dijana pada : {{ date('d/m/Y H:i A') }}
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
    <!-- <div class="header">
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
    </div> -->
    <div class="second-header">
        <table style="border: none !important;" width="100%">
            <tbody>
                <tr style="text-align: center; text-transform:uppercase; font-weight:bold;">
                    <td>
                        <p>
                            Senarai Aduan Penyelenggaraan <br>
                            {{ $date_start . ' - ' . $date_end }}
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
                    <th>Pengadu</th>
                    <th>Kategori</th>
                    <th>Lokasi</th>
                    <th>Jenis Kerosakan</th>
                    <th>Status Aduan</th>
                    <th>Tarikh Aduan</th>
                    <th>Prestasi Vendor</th>
                </tr>
            </thead>
                @php $no = 1 @endphp
            <tbody>
                @forelse ($results as $result)
                    <tr>
                        <td style="width:3% !important">{{ $no++ }}</td>
                        <td style="width:20% !important">{{ @$result->user_name }}</td>
                        <td style="width:10% !important">{{ @$result->kategori_name }}</td>
                        <td style="width:25% !important">{{ @$result->lokasi_full_name }}</td>
                        <td style="width:12% !important">{{ @$result->jenis_kerosakan }}</td>
                        <td style="width:10% !important">{{ @$result->status_name }}</td>
                        <td style="width:10% !important">{{ @$result->created_at }}</td>
                        <td style="width:10% !important">{{ @$result->prestasi_vendor_name }}</td>
                    </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center">
                        Tiada Data Dijumpai
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</html>