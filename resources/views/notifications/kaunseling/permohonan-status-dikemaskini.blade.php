<x-mail::message>
# #  Status Permohonan Sesi Kaunseling - Rujukan Permohonan: {{ $kaunseling->no_permohonan }}

Kami ingin memaklumkan bahawa terdapat perubahan dalam status permohonan sesi kaunseling anda, dengan rujukan permohonan {{ $kaunseling->no_permohonan }}. Berikut adalah butiran status terkini:

<x-mail::table>
| Maklumat Status Permohonan |                    |
| ------------------- |:-------------------:|
| No. Permohonan      | {{ $kaunseling->no_permohonan }} |
| Jenis Fasiliti      | {{ $kaunseling->jenis_fasiliti }} |
| Tarikh Permohonan   | {{ $kaunseling->tarikh_permohonan->format('d/m/Y') }} |
| Status Permohonan   | {{ $kaunseling->status_label }} |
</x-mail::table>

Kami ingin memberitahu bahawa permohonan anda {{ $kaunseling->status_label }}. Sila merujuk kepada maklumat di atas untuk mendapatkan penjelasan lanjut.

Sila klik butang di bawah untuk melihat maklumat permohonan anda.

<x-mail::button :url="route('pengurusan.hep.kaunseling.show', $kaunseling->id)">
Lihat Permohonan
</x-mail::button>

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
