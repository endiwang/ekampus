<x-mail::message>
# Pembayaran Selesai

Pembayaran anda untuk bil #{{ $bil->doc_no }} telah diterima dan disahkan.

Kami lampirkan resit pembayaran dari sistem.

Terima Kasih,<br>
{{ config('app.name') }}
</x-mail::message>
