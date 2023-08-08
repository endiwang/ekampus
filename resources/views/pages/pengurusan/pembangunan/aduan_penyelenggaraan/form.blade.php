@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Aduan Penyelenggaraan</h1>
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                <li class="breadcrumb-item text-muted">
                    <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Utama</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Pembangunan</li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Aduan Penyelenggaraan</li>

            </ul>
        </div>
    </div>
</div>
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card" id="advanceSearch">
                    <div class="card-header">
                        <h3 class="card-title">{{ $page_title }}</h3>
                    </div>
                    <div class="card-body py-5">
                        <form class="form" action="{{ $action }}" method="post">
                            @if($model->id) @method('PUT') @endif
                            @csrf

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('no_siri', 'No Siri', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('no_siri', @$aduan_penyelenggaraan->no_siri,['class' => 'form-control form-control-sm ', 'id' =>'no_siri','onkeydown' =>'return true','autocomplete' => 'off', 'required' => 'required', 'disabled' => 'disabled']) }}
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status', 'Status Aduan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('status', $status, @$aduan_penyelenggaraan->status, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('status') ? 'is-invalid':''), 'required' => 'required']) }}
                                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('pengadu', 'Nama Pengadu', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('pengadu', @$aduan_penyelenggaraan->user_name,['class' => 'form-control form-control-sm ', 'id' =>'pengadu','onkeydown' =>'return true','autocomplete' => 'off', 'required' => 'required', 'disabled' => 'disabled']) }}
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kategori', 'Kategori', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('kategori', $kategori_aduan, @$aduan_penyelenggaraan->kategori, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('kategori') ? 'is-invalid':''), 'required' => 'required', 'disabled' => 'disabled' ]) }}
                                        @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('type', 'Lokasi', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('type', $lokasi, @$aduan_penyelenggaraan->type, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('type') ? 'is-invalid':''), 'required' => 'required', 'disabled' => 'disabled' ]) }}
                                        @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('blok_id', 'Bangunan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('blok_id', [], @$aduan_penyelenggaraan->blok_id, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('blok_id') ? 'is-invalid':''), 'required' => 'required', 'disabled' => 'disabled' ]) }}
                                        @error('blok_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tingkat_id', 'Tingkat', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('tingkat_id', $tingkat, @$aduan_penyelenggaraan->tingkat_id, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('tingkat_id') ? 'is-invalid':''), 'required' => 'required', 'disabled' => 'disabled' ]) }}
                                        @error('tingkat_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('bilik_id', 'Bilik', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('bilik_id', [], @$aduan_penyelenggaraan->bilik_id, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('bilik_id') ? 'is-invalid':''), 'required' => 'required', 'disabled' => 'disabled' ]) }}
                                        @error('bilik_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jenis_kerosakan', 'Jenis Kerosakan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('jenis_kerosakan', @$aduan_penyelenggaraan->jenis_kerosakan ?? old('jenis_kerosakan'),['class' => 'form-control form-control-sm '.($errors->has('jenis_kerosakan') ? 'is-invalid':''), 'id' =>'jenis_kerosakan','onkeydown' =>'return true','autocomplete' => 'off', 'required' => 'required', 'disabled' => 'disabled']) }}
                                        @error('jenis_kerosakan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('butiran', 'Butiran', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('butiran', @$aduan_penyelenggaraan->butiran,['class' => 'form-control form-control-sm form-control', 'rows'=>'10', 'required' => 'required', 'disabled' => 'disabled', 'id' =>'butiran']) }}
                                        @error('butiran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <hr>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('vendor_id', 'Vendor', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('vendor_id', [1 => 'Vendor 1', 2 => 'Vendor 2', 3 => 'Vendor 3'], @$aduan_penyelenggaraan->vendor_id, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('vendor_id') ? 'is-invalid':''), 'required' => 'required' ]) }}
                                        @error('vendor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('butiran_kerja', 'Remarks', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('butiran_kerja', @$aduan_penyelenggaraan->butiran_kerja,['class' => 'form-control form-control-sm form-control', 'rows'=>'10', 'required' => 'required', 'id' =>'butiran_kerja']) }}
                                        @error('butiran_kerja') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-paper-plane" style="vertical-align: initial"></i>Hantar
                                        </button>
                                        <a href="{{ route('pengurusan.pembangunan.aduan_penyelenggaraan.index') }}" class="btn btn-sm btn-light">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
    </div>
</div>
@endsection

@push('scripts')
<script>

$(document).ready(function(){
    $('[name="type"]').change();
});

$('[name="type"]').on('change', function(){
    if($(this).val())
    {
        $.ajax({
            type: 'GET',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            url: "{{ route('aduan_penyelenggaraan.get_block') }}",
            data: {
                type: $(this).val(),
            },
            success: function (data) {

                var $select = $('[name="blok_id"]');                        
                $select.find('option').remove();

                $select.append(`<option value="">Sila Pilih</option>`);
                $.each(data.blok, function(key, value) {
                    $select.append(`<option value="${key}">${value}</option>`);
                });

                @if(!empty($aduan_penyelenggaraan->blok_id))
                    $('[name="blok_id"] option[value="{{ $aduan_penyelenggaraan->blok_id }}"]').attr('selected', 'selected');
                    $('[name="blok_id"]').change();
                @endif
            },
            error: function (data) {
                //                
            }
        });
    }
})
$('[name="blok_id"], [name="tingkat_id"]').on('change', function(){
    if($('[name="blok_id"]').val() && $('[name="tingkat_id"]').val())
    {
        console.log('aa');
        $.ajax({
            type: 'GET',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            url: "{{ route('aduan_penyelenggaraan.get_bilik') }}",
            data: {
                blok_id: $('[name="blok_id"]').val(),
                tingkat_id: $('[name="tingkat_id"]').val(),
            },
            success: function (data) {
                
                var $select = $('[name="bilik_id"]');                        
                $select.find('option').remove();

                $select.append(`<option value="">Sila Pilih</option>`);
                $.each(data.bilik, function(key, value) {
                    $select.append(`<option value="${key}">${value}</option>`);
                });

                @if(!empty($aduan_penyelenggaraan->bilik_id))
                    $('[name="bilik_id"] option[value="{{ $aduan_penyelenggaraan->bilik_id }}"]').attr('selected', 'selected');
                    $('[name="bilik_id"]').change();
                @endif
            },
            error: function (data) {
                //                
            }
        });
    }
})
</script>
@endpush
