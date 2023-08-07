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
                                    {{ Form::label('kategori', 'Kategori', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('kategori', $kategori_aduan, null, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('kategori') ? 'is-invalid':''), 'required' => 'required' ]) }}
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
                                        {{ Form::select('type', $lokasi, null, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('type') ? 'is-invalid':''), 'required' => 'required' ]) }}
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
                                        {{ Form::select('blok_id', [], null, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('blok_id') ? 'is-invalid':''), 'required' => 'required' ]) }}
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
                                        {{ Form::select('tingkat_id', $tingkat, null, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('tingkat_id') ? 'is-invalid':''), 'required' => 'required' ]) }}
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
                                        {{ Form::select('bilik_id', [], null, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('bilik_id') ? 'is-invalid':''), 'required' => 'required' ]) }}
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
                                        {{ Form::text('jenis_kerosakan', $model->jenis_kerosakan ?? old('jenis_kerosakan'),['class' => 'form-control form-control-sm '.($errors->has('jenis_kerosakan') ? 'is-invalid':''), 'id' =>'jenis_kerosakan','onkeydown' =>'return true','autocomplete' => 'off', 'required' => 'required']) }}
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
                                        {{ Form::textarea('butiran','',['class' => 'form-control form-control-sm form-control', 'rows'=>'10', 'required' => 'required', 'id' =>'butiran']) }}

                                        {{-- <textarea class="form-control" id="tinymce" name="sebab_mohon"></textarea> --}}
                                        @error('butiran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-paper-plane" style="vertical-align: initial"></i>Hantar
                                        </button>
                                        <a href="{{ route('home') }}" class="btn btn-sm btn-light">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->

        @if(!empty($model->id))
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-header d-flex flex-row-reverse justify-content-between">
                        <div>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#export" class="btn btn-icon btn-info btn-sm hover-elevate-up mt-5" title="Muat Turun Senarai Pelajar">
                                <i class="fa fa-download"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body py-5">
                        {{ $dataTable->table(['class'=>'table table-striped table-row-bordered gy-5 gs-7 border rounded']) }}
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="export" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title">Muat Turun Senarai Pelajar</h3>
                        <button type="button" class="close btn btn-sm btn-default" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <form class="form-horizontal" action="{{ route('pengurusan.akademik.pengurusan_kelas.export_by_class') }}" method="POST" enctype="multipart/form-data" formtarget="_blank" target="_blank">
                        @csrf
                            <div class="modal-body">
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('export_type', 'Jenis Muat Turun', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('export_type',
                                            [
                                                'pdf' => 'PDF',
                                                //'excel' => 'Excel'
                                            ],
                                            null, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2' ]) }}
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="class_id" value="{{ $model->id }}">
                            </div>
                            <div class="modal-footer">
                                <div class="d-flex">
                                    <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                        Hantar
                                    </button>
                                    <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                                </div>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
$("#tarikh_kes").daterangepicker({
        autoApply : true,
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        minYear: parseInt(moment().subtract(1,'y').format("YYYY")),
        maxYear: parseInt(moment().add(4,'y').format("YYYY")),
        locale: {
            format: 'DD/MM/YYYY'
        }
    },function(start, end, label) {
        var datePicked = moment(start).format('DD/MM/YYYY');
        $("#tarikh_kes").val(datePicked);
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
            },
            error: function (data) {
                //                
            }
        });
    }
})
</script>
@endpush
