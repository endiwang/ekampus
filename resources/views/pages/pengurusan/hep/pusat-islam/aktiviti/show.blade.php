@php
    $title = __('Senarai Aktiviti');
    $breadcrumbs = [
        'Pusat Islam' => false,
        'Senarai Aktiviti' => route('pengurusan.hep.pusat-islam.aktiviti.index'),
    ];

@endphp
@extends('layouts.master.main')
@section('content')
    <x-container>
        <div class="row fv-row mb-2">
            <div class="col-md-3">
                <label class="col-form-label fw-semibold fs-6 pb-0 pt-0">Aktiviti</label>
            </div>

            <div class="col-md-9">
                <div class="w-100">
                    <p class="mt-2">{{ $aktiviti->nama }} </p>
                </div>
            </div>
        </div>

        <div class="row fv-row mb-2">
            <div class="col-md-3">
                <label class="col-form-label fw-semibold fs-6 pb-0 pt-0">Tarikh</label>
            </div>

            <div class="col-md-9">
                <div class="w-100">
                    <p class="mt-2">{{ optional($aktiviti->tarikh)->format('d F Y') }} </p>
                </div>
            </div>
        </div>

        <div class="row fv-row mb-2">
            <div class="col-md-3">
                <label class="col-form-label fw-semibold fs-6 pb-0 pt-0">Adakah Hari Kebesaran Islam?</label>
            </div>

            <div class="col-md-9">
                <div class="w-100">
                    <p class="mt-2">
                        @include('partials.status', ['status' => $aktiviti->hari_kebesaran_islam ? true : false])
                    </p>
                </div>
            </div>
        </div>
    </x-container>
@endsection
