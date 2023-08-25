@php
    $title = __('Senarai Kaunseling');
    $breadcrumbs = [
        'Kaunseling' => false,
        'Senarai Kaunseling' => false,
    ];
    $buttons = [
        [
            'title' => 'Permohonan Baru',
            'route' => route('pengurusan.hep.kaunseling.create'),
            'button_class' => 'btn btn-sm btn-primary fw-bold',
            'icon_class' => 'fa fa-plus-circle',
            'is_show' => auth()->user()->can('create-kaunseling')
        ],
    ];
@endphp
@extends('layouts.master.main')
@section('content')
    <x-container>
        {{ $dataTable->table() }}
    </x-container>
@endsection

@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush
