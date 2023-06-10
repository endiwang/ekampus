<x-mail::message>
# Tahniah

Anda telah terpilih untuk mengikuti program {{ $data->kursus->nama }} bagi sesi {{ $data->sesi->nama }}.

Maklumat tawaran :-

Pusat pengajian : {{ $data->pusat_pengajian->nama }}<br>
Kursus : {{ $data->kursus->nama }}<br>
Sesi pengajian : {{ $data->sesi->nama }}<br>
Tempat pendaftaran : {{ $data->nama_tempat }}<br>
Alamat tempat pendaftaran : {{ $data->alamat_pendaftaran }}<br>
Tarikh pendaftaran : {{ \Carbon\Carbon::parse($data->tarikh)->format('d/m/Y') }}<br>
Masa pendaftaran : {{ $data->masa}} {{ $data->waktu }}<br>

Sila semak dashboard pemohon untuk maklumat lanjut menerima atau menolak tawaran ini. Sekiranya tiada maklum balas dari pemohon, pemohon dianggap menolak tawaran secara automatik.

Terima Kasih,<br>
{{ config('app.name') }}
</x-mail::message>
