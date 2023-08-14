<x-mail::message>
# Tahniah

Anda telah terpilih untuk menghadiri temuduga untuk kemasukkan ke program {{ $data->kursus->nama }} bagi sesi {{ $data->sesi->nama }}.

Maklumat temuduga :-

Pusat pengajian : {{ $data->pusat_pengajian->nama }}<br>
Kursus : {{ $data->kursus->nama }}<br>
Sesi pengajian : {{ $data->sesi->nama }}<br>
Tempat temuduga : {{ $data->nama_tempat }}<br>
Alamat tempat temuduga : {{ $data->alamat_temuduga }}<br>
Tarikh temuduga : {{ \Carbon\Carbon::parse($data->tarikh)->format('d/m/Y') }}<br>
Masa temuduga : {{ $data->masa}} {{ $data->waktu }}<br>

Sila semak dashboard pemohon untuk maklumat lanjut.

Terima Kasih,<br>
{{ config('app.name') }}
</x-mail::message>
