@php
    $title = __('Senarai Lookup');
    $breadcrumbs = [
        'Tetapan' => false,
        'Senarai Lookup' => false,
    ];
    $create_route = str_replace('.lookup.index', '.lookup.create', request()->route()->getName());
    $buttons = [
        [
            'title' => 'Tambah Maklumat Baru',
            'route' => route($create_route, ['category' => $category]),
            'button_class' => 'btn btn-sm btn-primary fw-bold',
            'icon_class' => 'fa fa-plus-circle',
            'is_show' => auth()->user()->can('create-lookup') && auth()->user()->can('create-'.$category)
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
