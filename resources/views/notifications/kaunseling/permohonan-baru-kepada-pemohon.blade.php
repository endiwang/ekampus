<x-mail::message>
# Pengesahan Permohonan Sesi Kaunseling Diterima

Kami ingin mengesahkan bahawa kami telah berjaya menerima permohonan anda untuk sesi kaunseling.

Berikut adalah maklumat permohonan anda:

<x-mail::table>
| Maklumat Permohonan |                    |
| ------------------- |:-------------------:|
| No. Permohonan      | {{ $kaunseling->no_permohonan }} |
| Jenis Fasiliti      | {{ $kaunseling->jenis_fasiliti }} |
| Tarikh Permohonan   | {{ $kaunseling->tarikh_permohonan->format('d/m/Y') }} |
</x-mail::table>

Sila klik butang di bawah untuk melihat maklumat permohonan anda.

<x-mail::button :url="route('kaunseling.show', $kaunseling->id)">
Lihat Permohonan
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
