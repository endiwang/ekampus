<x-mail::message>
# {{ $subject }}

Kerja aduan penyelenggaraan dengan nombor siri aduan #{{ $aduan_penyelenggaraan->no_siri }} telah diproses.

@if($to_vendor)
Sila ambil langkah untuk menyelesaikan isu tersebut seperti yang dilaporkan.
@endif

Terima Kasih,<br>
{{ config('app.name') }}
</x-mail::message>
