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
                            @if($model->id) @method('PUT') @endif
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('pelajar', 'Pelajar', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <select class="form-control form-select form-select-sm" data-control="select2" name="pelajar" id="pelajar">
                                            <option value="">Pilih Pelajar</option>
                                            @foreach($students as $student)
                                            <option value="{{ $student->id }}" @if(!empty($model->pelajar_id) && $student->id == $model->pelajar_id) selected @endif>{{ $student->nama ?? null }} ({{ $student->no_matrik ?? null }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kod_berhenti', 'Kod Berhenti', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('kod_berhenti', $sebab_berhenti, $model->kod_berhenti, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2' ]) }}
                                        @error('kod_berhenti') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('sebab_berhenti', 'Sebab Berhenti', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>

                                <div class="col-md-9">
                                    <div class="w-100">
                                        <textarea class="form-control" id="tinymce" name="sebab_berhenti">{{ $model->sebab_berhenti ?? old('body') }}</textarea>
                                        @error('sebab_berhenti') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_berhenti', 'Tarikh Berhenti', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_berhenti', Carbon\Carbon::parse($model->tarikh_berhenti)->format('d/m/Y') ?? old('tarikh_berhenti'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_berhenti') ? 'is-invalid':''), 'id' =>'tarikh_berhenti','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('tarikh_berhenti') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pengurusan.akademik.pengurusan.penamatan_pengajian.index') }}" class="btn btn-sm btn-light">Batal</a>
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
        height: 300
    });

    $("#tarikh_berhenti").daterangepicker({
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
        $("#tarikh_berhenti").val(datePicked);
    });

    

</script>

@endpush