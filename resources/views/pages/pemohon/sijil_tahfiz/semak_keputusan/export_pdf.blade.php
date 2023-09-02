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
    <h2>Keputusan Temuduga</h2>

    <br>
    <table class="table data">
        {{-- <tbody> --}}
            <tr>
                <th colspan="2">Maklumat Calon</th>
            </tr>
            <tr class="fw-bold fs-6 text-gray-800">
                <td width="25%">Nama Calon :</td>
                <td>{{ $pemarkahan->permohonanSijilTahfiz->name }}</td>
            </tr>
            <tr class="fw-bold fs-6 text-gray-800">
                <td width="25%">Kad Pengenalan :</td>
                <td>{{ $pemarkahan->pemohon->username }}</td>
            </tr>
            <tr class="fw-bold fs-6 text-gray-800">
                <td width="25%">Peringkat Kelulusan :</td>
                <td>{{ $pemarkahan->keputusan_peperiksaan }}</td>
            </tr>
        {{-- </tbody> --}}
    </table>

    <br>
    <table class="table data">
        <tr>
            <th colspan="2">Pemarkahan</th>
        </tr>
        <tbody>
            <tr class="fw-bold fs-6 text-gray-800">
                <td style="font-weight:bold">Al-Quran Syafawi</td>
                <td style="text-align: center;">{{ $pemarkahan->al_quran_syafawi }}%</td>
            </tr>
            <tr class="fw-bold fs-6 text-gray-800">
                <td style="font-weight:bold">Al-Quran Tahriri</td>
                <td style="text-align: center;">{{ $pemarkahan->al_quran_tahriri }}%</td>
            </tr>
            <tr>
                <td colspan="2" style="font-weight:bold">Pengetahuan Islam</td>
            </tr>
            <tr class="fw-bold fs-6 text-gray-800">
                <td>Tajwid</td>
                <td style="text-align: center;">{{ $pemarkahan->tajwid }}%</td>
            </tr>
            <tr class="fw-bold fs-6 text-gray-800">
                <td>Fiqh Ibadah</td>
                <td style="text-align: center;">{{ $pemarkahan->fiqh_ibadah }}%</td>
            </tr>
            <tr class="fw-bold fs-6 text-gray-800">
                <td>Akidah</td>
                <td style="text-align: center;">{{ $pemarkahan->akidah }}%</td>
            </tr>
            <tr>
                <td style="text-align: right">Markah</td>
                <td style="text-align: center;">{{ $pemarkahan->total_mark }}%</td>
            </tr>
        </tbody>
    </table>
    <span class="fs-8 text-muted text-danger">**Penafian: Dokumen ini bukan untuk kegunaan urusan rasmi.</span>
    <br>
    <span class="fs-8 text-muted text-danger">**Kiraan: Markah Keseluruhan X 100 / 300</span>
</html>
