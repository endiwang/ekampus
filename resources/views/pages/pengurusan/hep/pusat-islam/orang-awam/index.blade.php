@php
    $title = __('Pendaftaran Kelas Orang Awam');
    $breadcrumbs = [
        'Pusat Islam' => false,
        'Kelas Orang Awam' => false,
    ];
    $buttons = [
        [
            'title' => 'Jana Rekod Baru',
            'route' => route('pengurusan.hep.pusat-islam.orang-awam.create'),
            'button_class' => 'btn btn-sm btn-primary fw-bold',
            'icon_class' => 'fa fa-plus-circle',
            'is_show' => auth()->user()->can('create-pi-kelas-orang-awam')
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
