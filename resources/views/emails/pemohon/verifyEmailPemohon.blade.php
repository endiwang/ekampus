<x-mail::message>
# Pengesahan Emel

Sila sahkan emel anda dengan menekan butang "Sahkan Emel" dibawah untuk mendapatakan katalaluan untuk akuan pemohon anda.

<x-mail::button :url="route('verify_email_pemohon',$pemohon->verifyEmailPemohon->token)">
Sahkan Emel
</x-mail::button>

Terima Kasih,<br>
{{ config('app.name') }}
</x-mail::message>
