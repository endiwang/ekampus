<x-mail::message>
# Permohonan Sijil Tahfiz

{{ $permohonan->name }} telah membuat permohonanan sijil tahfiz bagi seri peperiksaan {{ $permohonan->tetapanSiriPeperiksaan->siri }}.

Sila lihat butiran lengkap pemohon bagi proses kelayakan.

Terima Kasih,<br>
{{ config('app.name') }}
</x-mail::message>