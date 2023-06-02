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
    <title>{{ $datas['konvo']->tajuk_konvo}}</title>

    <table width="98%" cellpadding="3" cellspacing="0" border="0" align="center" class="print">
        <tr align="center">
            <td colspan="4">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                    <tr>
                        <td width="20%" align="left"><img src="{{ asset('assets/media/darulquran/crestmalaysia.gif') }}" width="57" height="47" border="0"></td>
                        <td width="60%" align="center" valign="middle"><b></b><br></td>
                        <td width="20%" align="left" class="">No. Borang&nbsp;&nbsp;: JAKIM B41<br>No. Pindaan : 0</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td colspan="4">
            <table width="80%" align="center" border="1" cellpadding="5" cellspacing="0">
                <tr class="print">
                    <td width="30%">TAJUK  </td>
                    <td width="70%">: {{ $datas['konvo']->tajuk_konvo }}</td>
                </tr>
                <tr class="print">
                    <td>TARIKH / MASA </td>
                    <td colspan="3">: {{ \Carbon\Carbon::parse($datas['konvo']->tarikh)->format('d/m/Y') }}&nbsp;&nbsp;({{ $datas['konvo']->masa }} {{ $datas['konvo']->waktu }})</td>
                </tr>
                <tr class="print">
                    <td width="30%">JUMLAH REKOD  </td>
                    <td width="70%">: {{ $datas['pelajar']->count() }} Orang Pelajar</td>
                </tr>
            </table>
        </td></tr>
        <tr><td><br></td></tr>
    </table>

    <br/>

    <table class="table data" width="100%">
        <thead>
            <tr class="text-center">
                <th valign="top">Bil.</th>
                <th valign="top">Nama</th>
                <th valign="top">No. K/P</th>
                <th valign="top">L/P</th>
                <th valign="top">No Matrik</th>
                <th valign="top">Sesi Kemasukan</th>
                <th valign="top">Kursus</th>
                <th valign="top">Pusat Pengjian</th>
                <th valign="top">Syukbah</th>
                <th valign="top">CGPA</th>
                <th valign="top">Saiz<br>Kopiah</th>
                <th valign="top">Status<br>Kehadiran</th>
            </tr>
        </thead>

        <tbody class="table-content">
            @php($index = 1)
            @foreach($datas['pelajar'] as $data)
            <tr class="content">
                <td>{{ $index++ }}</td>
                <td>
                    {{ $data->pelajar->nama ?? null }} <br/>
                </td>
                <td style="text-align: center;">{{ $data->pelajar->no_ic ?? null }}</td>
                <td style="text-align: center;">{{ $data->pelajar->jantina ?? null }}</td>
                <td style="text-align: center;">{{ $data->pelajar->no_matrik ?? null }}</td>
                <td style="text-align: center;">{{ $data->pelajar->sesi->nama ?? null }}</td>
                <td style="text-align: center;">{{ $data->pelajar->kursus->nama ?? null }}</td>
                <td style="text-align: center;">{{ $data->pelajar->pusat_pengajian->nama ?? null }}</td>
                <td style="text-align: center;">{{ $data->pelajar->syukbah->nama ?? null }}</td>
                <td style="text-align: center;">{{ $data->pelajar->mata_akhir ?? null }}</td>
                <td style="text-align: center;">{{ $data->saiz_kopiah ?? null }}</td>
                <td style="text-align: center;">@if($data->pelajar->kehadiran == 0) Tidak @else Hadir @endif</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</html>
