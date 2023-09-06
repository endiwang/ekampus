@php
    $title = __('Senarai Pilihan Raya');
    $breadcrumbs = [
        'Kemahiran Insaniah' => false,
        'Pilihan Raya' => false,
    ];
    $buttons = [
        [
            'title' => 'Jana Rekod Baru',
            'route' => route('pengurusan.hep.kemahiran-insaniah.pilihan-raya.create'),
            'button_class' => 'btn btn-sm btn-primary fw-bold',
            'icon_class' => 'fa fa-plus-circle',
            'is_show' => auth()->user()->can('create-ki-pilihan-raya')
        ],
    ];
@endphp
@extends('layouts.master.main')
@section('content')
    <x-container>
        <div>{{ $dataTable->table() }}</div>
    </x-container>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
