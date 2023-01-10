<x-mail::message>
# Order Shipped

Sila sahkan email anda dengan menekan butang "Sahkan Email" dibawah untuk mendapatakan katalaluan untuk akuan pemohon anda.

<x-mail::button :url="route('verify_email_pemohon',$pemohon->verifyEmailPemohon->token)">
Sahkan Email
</x-mail::button>

Terima Kasih,<br>
{{ config('app.name') }}
</x-mail::message>
