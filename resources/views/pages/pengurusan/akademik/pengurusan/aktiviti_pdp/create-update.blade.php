@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
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
                        <form class="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @csrf
                            @if($model->id) @method('PUT') @endif
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('title', 'Tajuk', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('title', $model->title ?? old('title'),['class' => 'form-control form-control-sm '.($errors->has('title') ? 'is-invalid':''), 'id' =>'title','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('subjek', 'Subjek', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('subjek', $subjects, $model->subjek_id, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2' ]) }}
                                        @error('subjek') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kelas', 'Kelas', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('kelas', $classes, $model->kelas_id, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2' ]) }}
                                        @error('kelas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_rekod', 'Tarikh Rekod', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_rekod', Carbon\Carbon::parse($model->record_date)->format('d/m/Y') ?? old('tarikh_rekod'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_rekod') ? 'is-invalid':''), 'id' =>'tarikh_rekod','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('tarikh_rekod') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('description', 'Deskripsi', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>

                                <div class="col-md-9">
                                    <div class="w-100">
                                        <textarea class="form-control" id="tinymce" name="description">{{ $model->description ?? old('body') }}</textarea>
                                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pengurusan.akademik.pengurusan.aktiviti_pdp.index') }}" class="btn btn-sm btn-light">Batal</a>
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
    tinymce.init({
        selector: 'textarea#tinymce',
        height: 600
    });

    const { createApp } = Vue

    createApp({
        data() {
            return {
            }
        },
        methods: {
        },
        mounted() {
        },
    }).mount('#advanceSearch')

    $("#tarikh_rekod").daterangepicker({
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
        $("#tarikh_rekod").val(datePicked);
    });

    

</script>

@endpush