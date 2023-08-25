<x-mail::message>
# Permohonan untuk Sesi Kaunseling - Rujukan Permohonan: {{ $kaunseling->no_permohonan }}

Kami ingin mengesahkan bahawa permohonan untuk sesi kaunseling telah diterima melalui sistem permohonan yang disediakan. Permohonan ini sedang dalam proses penilaian dan kami berharap agar ia dapat dipertimbangkan dengan segera.

Berikut adalah butiran permohonan yang kami terima:

<x-mail::table>
| Maklumat Permohonan |                    |
| ------------------- |:-------------------:|
| No. Permohonan      | {{ $kaunseling->no_permohonan }} |
| Jenis Fasiliti      | {{ $kaunseling->jenis_fasiliti }} |
| Tarikh Permohonan   | {{ $kaunseling->tarikh_permohonan->format('d/m/Y') }} |
</x-mail::table>

Sila klik butang di bawah untuk melihat maklumat permohonan.

Sila klik butang di bawah untuk melihat maklumat permohonan anda.

<x-mail::button :url="route('pengurusan.hep.kaunseling.show', $kaunseling->id)">
Lihat Permohonan
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
