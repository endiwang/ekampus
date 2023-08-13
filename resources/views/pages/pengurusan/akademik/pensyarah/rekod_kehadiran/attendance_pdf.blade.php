<style type="text/css">
    html {
        font-family: Arial, Helvetica, sans-serif
    }

    table {
        font-size: 12px;
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
    }

    table tr td {
        border-top: 1px solid black;
        border-bottom: 1px solid black;
        padding: 10px;
        text-align: center;
    }
    
    table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .label {
        font-weight: bold;
    }

</style>

<?php
    $date = date("d M Y h:i:s A");
?>

<html>
    <div>
        <p style="font-weight: bold; font-size: 16px;">Senarai Kehadiran Pensyarah</p>
        <p style="font-weight: bold; font-size: 13px;">
            Tarikh : {{ $tarikh_mula }} Hingga {{ $tarikh_akhir ?? null }}
        </p>
        <p style="font-weight: bold; font-size: 12px;">Generated At : {{ $date }}</p>
    </div>
    <div>
        <table class="table table-hover table-striped" width="100%">
            <thead>
                <tr>
                    <th valign="top">No.</th>
                    <th valign="top">Nama Pensyarah</th>
                    <th valign="top">No kakitangan</th>
                    <th valign="top">Tarikh</th>
                    <th valign="top">Masa</th>
                </tr>
            </thead>
            <tbody class="table-content">
                @php 
                    $index = 1 
                @endphp
                @forelse($datas as $data)
                <tr class="content">
                    <td>{{ $index++ }}</td>
                    <td>{{ $data->staff->nama ?? null}}</td>
                    <td>{{ $data->staff->staff_id ?? null}}</td>
                    <td>{{ Utils::formatDate($data->tarikh) ?? '' }}</td>
                    <td>{{ Utils::formatTime($data->waktu) ?? '' }}</td>
                </tr>
                @empty
                <tr class="content">
                    <td colspan="5" style="text-align: center">Tiada Maklumat Kehadiran</td>
                </tr>
                @endforelse
            </tbody>
    
        </table>
    </div>
</html>