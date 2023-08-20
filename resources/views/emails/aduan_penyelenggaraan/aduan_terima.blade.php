<x-mail::message>
# Aduan Penyelenggaraan Baru

Aduan penyelenggaraan baru dengan nombor siri aduan #{{ $aduan_penyelenggaraan->no_siri }} telah diterima melalui sistem.

@if($to_unit_pembangunan)
Sila semak butiran aduan dan ambil tindakan yang sesuai.
@endif

Terima Kasih,<br>
{{ config('app.name') }}
</x-mail::message>
