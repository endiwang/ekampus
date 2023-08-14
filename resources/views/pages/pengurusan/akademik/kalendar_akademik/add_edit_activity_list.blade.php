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
                        <form class="form" action="{{ $action }}" method="post">
                            @csrf
                            @if($model->id) @method('PUT') @endif
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('aktiviti', 'Nama Aktiviti', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('aktiviti', $model->aktiviti ?? old('aktiviti'),['class' => 'form-control form-control-sm '.($errors->has('aktiviti') ? 'is-invalid':''), 'id' =>'aktiviti','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('aktiviti') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_mula', 'Tarikh Mula', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_mula',Carbon\Carbon::parse($model->start_date)->format('d/m/Y'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_mula') ? 'is-invalid':''), 'id' =>'tarikh_mula','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        @error('tarikh_mula') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_tamat', 'Tarikh Tamat', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_tamat',Carbon\Carbon::parse($model->end_date)->format('d/m/Y'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_tamat') ? 'is-invalid':''), 'id' =>'tarikh_tamat','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        @error('tarikh_tamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tempoh', 'Tempoh', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-8">
                                    <div class="w-100">
                                        {{ Form::text('tempoh', $model->duration ?? old('duration'),['class' => 'form-control form-control-sm '.($errors->has('tempoh') ? 'is-invalid':''), 'id' =>'tempoh','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('tempoh') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                <div class="col-md-1 text-md-start">
                                    {{ Form::label('hari', 'Hari', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                            </div>
                            

                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pengurusan.akademik.guru_tasmik.index') }}" class="btn btn-sm btn-light">Batal</a>
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
$("#tarikh_mula").daterangepicker({
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
        $("#tarikh_mula").val(datePicked);
});
$("#tarikh_tamat").daterangepicker({
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
        $("#tarikh_tamat").val(datePicked);
});
</script>
@endpush