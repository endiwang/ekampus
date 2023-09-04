@php
    if (!isset($sesi)) {
        $sesi = new \App\Models\KemahiranInsaniah\PilihanRaya\Sesi();
    }

    $title = __('Pilihan Raya');
    $breadcrumbs = [
        'Kemahiran Insaniah' => false,
        'Pilihan Raya' => route('pengurusan.hep.kemahiran-insaniah.pilihan-raya.index'),
    ];

    if($sesi->id) {
        $breadcrumbs['Maklumat Pilihan Raya'] = route('pengurusan.hep.kemahiran-insaniah.pilihan-raya.show', $sesi->id);
        $breadcrumbs['Kemaskini Sesi Pilihan Raya'] = false;
    } else {
        $breadcrumbs['Sesi Pilihan Raya Baru'] = false;
    }
@endphp

@extends('layouts.master.main')
@section('content')
    <x-container>
        <livewire:forms.kemahiran-insaniah.pilihan-raya :sesi="$sesi" />
    </x-container>
@endsection
