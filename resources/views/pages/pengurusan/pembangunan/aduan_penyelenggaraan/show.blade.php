<table class="table table-bordered table-striped">
    <tr>
        <th style="width:20%">Kategori</th>
        <th>&nbsp;:&nbsp;</th>
        <td>{{ $aduan_penyelenggaraan->kategori_name }}</td>
    </tr>
    <tr>
        <th style="width:20%">Lokasi</th>
        <th>&nbsp;:&nbsp;</th>
        <td>{{ $aduan_penyelenggaraan->lokasi_name }}</td>
    </tr>
    <tr>
        <th style="width:20%">Bangunan</th>
        <th>&nbsp;:&nbsp;</th>
        <td>{{ $aduan_penyelenggaraan->blok->nama }}</td>
    </tr>
    <tr>
        <th style="width:20%">Tingkat</th>
        <th>&nbsp;:&nbsp;</th>
        <td>{{ $aduan_penyelenggaraan->tingkat->nama }}</td>
    </tr>
    <tr>
        <th style="width:20%">Bilik</th>
        <th>&nbsp;:&nbsp;</th>
        <td>{{ $aduan_penyelenggaraan->bilik->nama_bilik }}</td>
    </tr>
    <tr>
        <th style="width:20%">Jenis Kerosakan</th>
        <th>&nbsp;:&nbsp;</th>
        <td>{{ $aduan_penyelenggaraan->jenis_kerosakan }}</td>
    </tr>
    <tr>
        <th style="width:20%">Gambar</th>
        <th>&nbsp;:&nbsp;</th>
        <td>
            
        </td>
    </tr>
    <tr>
        <th style="width:20%">Butiran</th>
        <th>&nbsp;:&nbsp;</th>
        <td>{!! nl2br($aduan_penyelenggaraan->butiran) !!}</td>
    </tr>
</table>