<x-mail::message>
# Borang Kepuasan Pelanggan - Penilaian Sesi Kaunseling Anda

Kepada Para Pelajar yang Terhormat,

Kami berharap anda dalam keadaan sihat sejahtera. Terima kasih kerana telah mengambil masa untuk melibatkan diri dalam sesi kaunseling kami. Tujuan kami adalah untuk menyokong anda dalam perkembangan akademik dan emosi, serta memastikan pengalaman pendidikan anda di sini adalah positif dan memuaskan.

Kami ingin mendengar pandangan anda mengenai sesi kaunseling yang baru-baru ini anda alami. Maklum balas anda adalah penting untuk memastikan kami terus meningkatkan perkhidmatan kami. Kami berharap anda dapat meluangkan sedikit masa untuk mengisi borang kepuasan pelanggan.

<x-mail::button :url="route('pengurusan.hep.borang-kepuasan-pelanggan-kaunseling.update', $kaunseling->id)">
Borang Kepuasan Pelanggan
</x-mail::button>

Kami menghargai masa dan maklum balas anda. Maklum balas anda akan membantu kami menyediakan perkhidmatan yang lebih baik dan lebih relevan kepada semua pelajar. Jika anda ingin berbincang lebih lanjut tentang pengalaman anda atau memerlukan kaunseling lanjutan, jangan ragu untuk menghubungi kami di Unit Kaunseling.

Terima kasih kerana menjadi sebahagian daripada komuniti kami. Kami berharap anda terus berjaya dalam usaha akademik dan perkembangan diri.

Sekian, terima kasih.

Terima kasih,<br>
{{ config('app.name') }}
</x-mail::message>
