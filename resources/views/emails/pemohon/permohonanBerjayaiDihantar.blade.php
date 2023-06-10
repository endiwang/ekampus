<x-mail::message>
# Tahniah

Permohonan anda berjaya dihantar.

Maklumat permohonan :-<br>
Nama pemohon : {{ $permohonan->nama }}
No kad pengenalan : {{ $permohonan->no_ic }}<br>
Pusat pengajian : {{ $permohonan->pusat_pengajian->nama }}<br>
Kursus : {{ $permohonan->kursus->nama }}<br>
Sesi pengajian : {{ $permohonan->sesi->nama }}

Sila semak dashboard pemohon untuk mengetahui status permohonan anda.

Terima Kasih,<br>
{{ config('app.name') }}
</x-mail::message>
