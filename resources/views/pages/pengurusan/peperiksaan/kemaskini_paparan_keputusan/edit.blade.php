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
                        <div class="card-body py-5">
                            <div class="row fv-row mb-2" >
                                <form class="form" action="{{ $action }}" method="post">
                                    @csrf
                                    @if($model->id) @method('PUT') @endif
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('status_sem_1', 'Semester 1', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                {{ Form::checkbox('status_sem_1', '1', $model->status_keputusan, ['class' => 'form-check-input h-25px w-60px']); }}
                                                <label class="form-check-label fs-7 fw-semibold" for="allowmarketing">Aktif</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-md-end">
                                            {{ Form::label('tarikh_sem_1', 'Tarikh', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                {{ Form::text('tarikh_sem[1]', $tarikh_sem_1,['class' => 'form-control form-control-sm '.($errors->has('tarikh_sem_1') ? 'is-invalid':''), 'id' =>'tarikh_sem1','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('status_sem_2', 'Semester 2', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                {{ Form::checkbox('status_sem_2', '1', $model->status_keputusan_2, ['class' => 'form-check-input h-25px w-60px']); }}
                                                <label class="form-check-label fs-7 fw-semibold" for="allowmarketing">Aktif</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-md-end">
                                            {{ Form::label('tarikh_sem_2', 'Tarikh', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                {{ Form::text('tarikh_sem[2]', $tarikh_sem_2, ['class' => 'form-control form-control-sm '.($errors->has('tarikh_sem_2') ? 'is-invalid':''), 'id' =>'tarikh_sem2','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>
                                    
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('status_sem_3', 'Semester 3', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                {{ Form::checkbox('status_sem_3', '1', $model->status_keputusan_3, ['class' => 'form-check-input h-25px w-60px']); }}
                                                <label class="form-check-label fs-7 fw-semibold" for="allowmarketing">Aktif</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-md-end">
                                            {{ Form::label('tarikh_sem_3', 'Tarikh', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                {{ Form::text('tarikh_sem[3]', $tarikh_sem_3, ['class' => 'form-control form-control-sm '.($errors->has('tarikh_sem_3') ? 'is-invalid':''), 'id' =>'tarikh_sem3','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>

                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('sem_4', 'Semester 4', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                {{ Form::checkbox('status_sem_4', '1', $model->status_keputusan_4, ['class' => 'form-check-input h-25px w-60px']); }}
                                                <label class="form-check-label fs-7 fw-semibold" for="allowmarketing">Aktif</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-md-end">
                                            {{ Form::label('tarikh_sem_4', 'Tarikh', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                {{ Form::text('tarikh_sem[4]', $tarikh_sem_4, ['class' => 'form-control form-control-sm '.($errors->has('tarikh_sem_4') ? 'is-invalid':''), 'id' =>'tarikh_sem4','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>

                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('sem_5', 'Semester 5', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                {{ Form::checkbox('status_sem_5', '1', $model->status_keputusan_5, ['class' => 'form-check-input h-25px w-60px']); }}
                                                <label class="form-check-label fs-7 fw-semibold" for="allowmarketing">Aktif</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-md-end">
                                            {{ Form::label('tarikh_sem_5', 'Tarikh', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                {{ Form::text('tarikh_sem[5]', $tarikh_sem_5, ['class' => 'form-control form-control-sm '.($errors->has('tarikh_sem_5') ? 'is-invalid':''), 'id' =>'tarikh_sem5','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>

                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('sem_6', 'Semester 6', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                {{ Form::checkbox('status_sem_6', '1', $model->status_keputusan_6, ['class' => 'form-check-input h-25px w-60px']); }}
                                                <label class="form-check-label fs-7 fw-semibold" for="allowmarketing">Aktif</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-md-end">
                                            {{ Form::label('tarikh_sem_6', 'Tarikh', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                {{ Form::text('tarikh_sem[6]', $tarikh_sem_6, ['class' => 'form-control form-control-sm '.($errors->has('tarikh_sem_6') ? 'is-invalid':''), 'id' =>'tarikh_sem6','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>

                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('sem_7', 'Semester 7', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                {{ Form::checkbox('status_sem_7', '1', $model->status_keputusan_7, ['class' => 'form-check-input h-25px w-60px']); }}
                                                <label class="form-check-label fs-7 fw-semibold" for="allowmarketing">Aktif</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-md-end">
                                            {{ Form::label('tarikh_sem_7', 'Tarikh', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                {{ Form::text('tarikh_sem[7]', $tarikh_sem_7, ['class' => 'form-control form-control-sm '.($errors->has('tarikh_sem_7') ? 'is-invalid':''), 'id' =>'tarikh_sem7','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>

                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('sem_8', 'Semester 8', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-1">
                                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                {{ Form::checkbox('status_sem_8', '1', $model->status_keputusan_8, ['class' => 'form-check-input h-25px w-60px']); }}
                                                <label class="form-check-label fs-7 fw-semibold" for="allowmarketing">Aktif</label>
                                            </div>
                                        </div>
                                        <div class="col-md-2 text-md-end">
                                            {{ Form::label('tarikh_sem_8', 'Tarikh', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                {{ Form::text('tarikh_sem[8]', $tarikh_sem_8, ['class' => 'form-control form-control-sm '.($errors->has('tarikh_sem_8') ? 'is-invalid':''), 'id' =>'tarikh_sem8','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                        <div class="col-md-3"></div>
                                    </div>

                                    <div class="row mb-0">
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('status_kep_ulangan', 'Status Keputusan Ulangan', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required pb-0']) }}
                                        </div>
                                        
                                        <div class="col-lg-9">
                                            <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                                {{ Form::checkbox('status_kep_ulangan', '1', $model->status_keputusan_ulangan, ['class' => 'form-check-input h-25px w-60px']); }}
                                                <label class="form-check-label fs-7 fw-semibold" for="allowmarketing">Aktif</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-9 offset-md-3">
                                            <div class="d-flex">
                                                <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                    <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                                </button>
                                                <a href="{{ route('pengurusan.peperiksaan.kemaskini_paparan_keputusan.index') }}" class="btn btn-sm btn-light">Batal</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
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
        $("#tarikh_sem1").daterangepicker({
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
            $("#tarikh_sem1").val(datePicked);
        });

        $("#tarikh_sem2").daterangepicker({
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
            $("#tarikh_sem2").val(datePicked);
        });

        $("#tarikh_sem3").daterangepicker({
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
            $("#tarikh_sem3").val(datePicked);
        });

        $("#tarikh_sem4").daterangepicker({
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
            $("#tarikh_sem4").val(datePicked);
        });

        $("#tarikh_sem5").daterangepicker({
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
            $("#tarikh_sem5").val(datePicked);
        });

        $("#tarikh_sem6").daterangepicker({
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
            $("#tarikh_sem6").val(datePicked);
        });

        $("#tarikh_sem7").daterangepicker({
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
            $("#tarikh_sem7").val(datePicked);
        });

        $("#tarikh_sem8").daterangepicker({
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
            $("#tarikh_sem8").val(datePicked);
        });
    </script>
@endpush