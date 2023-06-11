<style>
    html
    {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 13px;
    }

    .header-title {
        text-transform: uppercase;
    }

    .data {
        border-collapse: collapse;
    }

    .data thead {
        text-transform: uppercase !important;
        border: 1px solid black !important;
        background-color: #80ABF2 !important;
    }

    .data thead th {
        padding: 5px !important;
        border: 1px solid black !important;

    }

    .data tbody tr td {
        padding: 5px !important;
        border: 1px solid black !important;
    }

    .data tbody tr:nth-child(even) {
        background-color: #EFEDFB !important;
    }


</style>

<html>
    <p class="header-title">Maklumat Tawaran Kemasukan Pelajar</p>

    <table class="table header" width="100%">
        <tbody class="table-content">
            <tr class="content">
                <td>Program Pengajian</td>
                <td>: {{ $datas['tawaran']->kursus->nama ?? null }}</td>
            </tr>
            <tr class="content">
                <td>Sesi Pengajian </td>
                <td>: {{ $datas['tawaran']->sesi->nama ?? null }}</td>
            </tr>
            <tr class="content">
                <td>Tarikh Pendaftaran</td>
                <td>: {{ Carbon\Carbon::parse($datas['tawaran']->tarikh)->format('d/m/Y') ?? null }}</td>
            </tr>
            <tr class="content">
                <td>Masa Pendaftaran</td>
                <td>: {{ $datas['tawaran']->masa ?? null }} {{ $datas['tawaran']->waktu ?? null }}</td>
            </tr>
            <tr class="content">
                <td>Tempat Pendaftaran</td>
                <td>: {{ $datas['tawaran']->nama_tempat ?? null }}</td>
            </tr>
            <tr class="content">
                <td>Alamat</td>
                <td>: {{ $datas['tawaran']->alamat_pendaftaran ?? null }}</td>
            </tr>
        </tbody>
    </table>

    <br/>

    <table class="table data" width="100%">
        <thead>
            <tr class="text-center">
                <th valign="top">Bil.</th>
                <th valign="top">Nama</th>
                <th valign="top">No. K/P</th>
                <th valign="top">No Telefon</th>
                <th valign="top">Status</th>
            </tr>
        </thead>

        <tbody class="table-content">
            @php($index = 1)
            @foreach($datas['pemohon'] as $data)
            <tr class="content">
                <td>{{ $index++ }}</td>
                <td>
                    {{ $data->pemohon->nama ?? null }} <br/>
                </td>
                <td style="text-align: center;">{{ $data->pemohon->no_ic ?? null }}</td>
                <td style="text-align: center;">{{ $data->pemohon->no_tel ?? null }}</td>
                <td style="text-align: center;">@if($data->pemohon->is_terima == 0) Tolak @else Terima @endif</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</html>
