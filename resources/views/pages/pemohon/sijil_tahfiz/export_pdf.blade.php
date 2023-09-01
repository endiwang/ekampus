<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
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
    <h2>Maklumat Temuduga</h2>

    <br>
    <table class="table data">
        <tr>
            <th colspan="2">Maklumat Calon</th>
        </tr>
        <tr class="fw-bold fs-6 text-gray-800">
            <td width="25%">Nama Calon :</td>
            <td>{{ $permohonan->name }}</td>
        </tr>
        <tr class="fw-bold fs-6 text-gray-800">
            <td width="25%">Kad Pengenalan :</td>
            <td>{{ $permohonan->pemohon->username }}</td>
        </tr>
    </table>

    <br>
    <table class="table data">
        <tr>
            <th colspan="2">Maklumat Peperiksaan Sijil Tahfiz</th>
        </tr>
        <tbody>
            <tr class="fw-bold fs-6 text-gray-800">
                <td style="font-weight:bold">Tarikh Perperiksaan</td>
                <td style="text-align: center;">{{ date('d/m/Y', strtotime($siri_peperiksaan->tarikh_peperiksaan)) }}</td>
            </tr>
            <tr class="fw-bold fs-6 text-gray-800">
                <td style="font-weight:bold">Zon Perperiksaan</td>
                <td style="text-align: center;">{{ strtoupper($permohonan->pusatPeperiksaan->name) }}</td>
            </tr>
            <tr class="fw-bold fs-6 text-gray-800">
                <td>Venue Perperiksaan</td>
                <td style="text-align: center;">{{ strtoupper($venue->address  ?? '') }}</td>
            </tr>
        </tbody>
    </table>
</html>
