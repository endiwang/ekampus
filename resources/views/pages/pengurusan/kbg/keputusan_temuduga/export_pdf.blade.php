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
    <title>{{ $datas['temuduga']->tajuk_borang}}</title>

    <table width="98%" cellpadding="3" cellspacing="0" border="0" align="center" class="print">
        <tr align="center">
            <td colspan="4">
                <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                    <tr>
                        <td width="20%" align="left"><img src="{{ asset('assets/media/darulquran/crestmalaysia.gif') }}" width="57" height="47" border="0"></td>
                        <td width="60%" align="center" valign="middle"><b>Tajuk Borang</b><br></td>
                        <td width="20%" align="left" class="">No. Borang&nbsp;&nbsp;: JAKIM B41<br>No. Pindaan : 0</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td colspan="4">
            <table width="80%" align="center" border="1" cellpadding="5" cellspacing="0">
                <tr class="print">
                    <td width="30%">PUSAT TEMUDUGA  </td>
                    <td width="70%">: {{ $datas['temuduga']->nama_tempat }}</td>
                </tr>
                <tr class="print">
                    <td>TARIKH / MASA </td>
                    <td colspan="3">: {{ \Carbon\Carbon::parse($datas['temuduga']->tarikh)->format('d/m/Y') }}&nbsp;&nbsp;{{ $datas['temuduga']->masa }} {{ $datas['temuduga']->waktu }}</td>
                </tr>
                <tr class="print">
                    <td width="30%">PANEL TEMUDUGA  </td>
                    <td width="70%">: {{ $datas['temuduga']->ketua->nama }} </td>
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
                <th valign="top">Hafazan<br>(50%)</th>
                <th valign="top">Tajwid<br>(20%)</th>
                <th valign="top">Penampilan<br>(10%)</th>
                <th valign="top">Pencapaian<br>Akademik<br>(20%)</th>
                <th valign="top">Jumlah<br>(100%)</th>
                <th valign="top">Catatan / Ulasan</th>
            </tr>
        </thead>

        <tbody class="table-content">
            @php($index = 1)
            @foreach($datas['markah_temuduga'] as $data)
            <tr class="content">
                <td>{{ $index++ }}</td>
                <td>
                    {{ $data->pemohon->nama ?? null }} <br/>
                    <span style="font-style:italic">GT : {{ $data->pemohon->nama ?? null}} </span>
                </td>
                <td style="text-align: center;">{{ $data->pemohon->no_ic ?? null }}</td>
                <td style="text-align: center;">{{ $data->pemohon->jantina ?? null }}</td>
                <td style="text-align: center;">{{ $data->hafazan == 0 ? '' : $data->hafazan }}</td>
                <td style="text-align: center;">{{ $data->tajwid == 0 ? '' : $data->tajwid}}</td>
                <td style="text-align: center;">{{ $data->sikap == 0 ? '' : $data->sikap}}</td>
                <td style="text-align: center;">{{ $data->akademik == 0 ? '' : $data->akademik}}</td>
                <td style="text-align: center;">{{ $data->jumlah == 0 ? '' : $data->jumlah}}</td>
                <td style="text-align: center;">{{ $data->catatan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</html>
