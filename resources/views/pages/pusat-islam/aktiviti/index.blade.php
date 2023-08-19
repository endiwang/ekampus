@extends('layouts.master.main')
@section('content')
    <x-container>
        {{-- @can('create-record') --}}
            <div class="d-flex justify-content-end mb-4">
                <a class="btn btn-sm btn-primary" href="#">Permohonan Baru</a>
            </div>
        {{-- @endcan --}}
        {{-- <div>{{ $dataTable->table() }}</div> --}}
    </x-container>
@endsection

@push('scripts')
    {{-- {{ $dataTable->scripts(attributes: ['type' => 'module']) }} --}}
@endpush
