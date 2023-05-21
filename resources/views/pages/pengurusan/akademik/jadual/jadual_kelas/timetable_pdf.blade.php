<style type="text/css">
    html {
        font-family: Arial, Helvetica, sans-serif
    }

    table {
        width: 100%;
        border: 1px solid black;
        border-collapse: collapse;
    }

    table tr td {
        border: 1px solid black;
        padding: 10px;
    }
    
    table tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    .label {
        font-weight: bold;
    }

</style>

<html>
    <div>
        <p style="font-weight: bold; font-size: 16px;">Jadual Waktu Kelas {{ $kelas->nama ?? null }}</p>
        <p style="font-weight: bold; font-size: 16px;">Status : {{ $status ?? null }}</p>
    </div>
    <div>
        <table class="table table-bordered" width="100%">
            <thead>
                <th>Waktu</th>
                @foreach($days as $index => $day)
                    <th>{{ $day }}</th>
                @endforeach
            </thead>
            <tbody>
                <tr>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</html>