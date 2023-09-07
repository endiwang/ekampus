<x-mail::message>
# Yuran Bil Baru

Yuran bil baru #{{ $bil->doc_no }} telah dikenakan kepada anda.

Kami lampirkan invois bil dari sistem.

<x-mail::button :url="route('public.yuran.invois', $bil->id_hash)">
Lihat Invois
</x-mail::button>

Terima Kasih,<br>
{{ config('app.name') }}
</x-mail::message>
