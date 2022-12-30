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
    <p class="header-title">Maklumat Kelas dan Senarai Pelajar</p>
    
    <table class="table header" width="100%">
        <tbody class="table-content">
            <tr class="content">
                <td>Nama Kelas</td>
                <td>{{ $datas['class_name'] ?? null }}</td>
            </tr>
            <tr class="content">
                <td> Bilangan Pelajar</td>
                <td>{{ $datas['max_student'] ?? null }}</td>
            </tr>
            <tr class="content">
                <td>Status</td>
                <td>{{ $datas['status'] ?? null }}</td>
            </tr>
        </tbody>
    </table>
    
    <br/>

    <table class="table data" width="100%">
        <thead>
            <tr class="text-center">
                <th valign="top">Bil.</th>
                <th valign="top">Nama Pelajar / Guru Tasmik</th>
                <th valign="top">No. Kad Pengenalan</th>
                <th valign="top">Program Pengajian [Syukbah]</th>
                <th valign="top">Sesi Pengajian</th>
                <th valign="top">Semester</th>
            </tr>
        </thead>
        
        <tbody class="table-content">
            @php($index = 1)
            @foreach($datas['students'] as $data)
            <tr class="content">
                <td>{{ $index++ }}</td>
                <td>
                    {{ $data->nama ?? null }} <br/>
                    <span style="font-style:italic">GT : {{ $data->nama ?? null}} </span>
                </td>
                <td style="text-align: center;">{{ $data->no_ic ?? null }}</td>
                <td style="text-align: center;">{{ $data->kursus->nama ?? null }}</td>
                <td style="text-align: center;">{{ $data->sesi->nama ?? null }}</td>
                <td style="text-align: center;">{{ $data->semester }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</html>