<x-mail::message>
# Order Shipped

Terima kasih kerana anda sudah mengesahkan emel anda. Sekarang anda boleh log masuk ke akuan pemohon menggunakan katalaluan dibawah

<x-mail::panel>
{{ $password }}
</x-mail::panel>

<x-mail::button :url="route('login_pemohon')">
Log Masuk
</x-mail::button>

Terima Kasih,<br>
{{ config('app.name') }}
</x-mail::message>
