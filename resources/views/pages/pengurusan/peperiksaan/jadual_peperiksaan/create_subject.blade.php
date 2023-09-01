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
                                    @if($tetapan_peperiksaan->id) @method('PUT') @endif
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('program_pengajian', 'Program Pengajian', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('program_pengajian', $program_pengajian, $tetapan_peperiksaan->kursus_id ?? old('program_pengajian'), ['data-control'=>'select2', 'placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm','id'=>'program_pengajian' ]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('pusat_pengajian', 'Pusat Pengajian', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('pusat_pengajian', $pusat_pengajian, $tetapan_peperiksaan->pusat_pengajian_id ?? old('pusat_pengajian'), ['data-control'=>'select2', 'placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm','id'=>'pusat_pengajian' ]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('sesi', 'Sesi Peperiksaan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('sesi', $sesi_peperiksaan, $tetapan_peperiksaan->sesi_id ?? old('sesi'), ['data-control'=>'select2', 'placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm','id'=>'sesi' ]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('semester', 'Semester', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('semester', $semester, $tetapan_peperiksaan->semester_id ?? old('semester'), ['data-control'=>'select2', 'placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm','id'=>'semester' ]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('syukbah', 'Syukbah', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('syukbah', $syukbah, $tetapan_peperiksaan->syukbah_id ?? old('syukbah'), ['data-control'=>'select2', 'placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm','id'=>'syukbah' ]) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-9 offset-md-3">
                                            <div class="d-flex">
                                                <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                    <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                                </button>
                                                <a href="{{ route('pengurusan.peperiksaan.jadual_peperiksaan.index') }}" class="btn btn-sm btn-light">Batal</a>
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
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="card">
                        <div class="card-body py-5">
                            <div class="row mb-3">
                                <div class="col-lg-6">
                                    <h5 class="fw-bold">Jadual Waktu</h5>
                                </div>
                                <div class="col-lg-6" style="text-align: right">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#tambahSubjek" class="btn btn-sm btn-primary fw-bold" title="Tambah Fail Hebahan Aktiviti">
                                        <i class="fa fa-plus-circle" style="vertical-align: initial"></i>Tambah Subjek
                                    </a>
                                    <a href="{{ route('pengurusan.peperiksaan.jadual_peperiksaan.muatturun_jadual', $id) }}" class="btn btn-sm btn-primary fw-bold" title="Tambah Fail Hebahan Aktiviti">
                                        <i class="fa fa-circle-down" style="vertical-align: initial"></i>Muat Turun Jadual
                                    </a>
                                </div>
                            </div>
                            {{ $dataTable->table(['class'=>'table table-striped table-row-bordered gy-5 gs-7 border rounded']) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="tambahSubjek" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Tambah Subjek</h3>
                            <button type="button" class="close btn btn-sm btn-default" data-bs-dismiss="modal">&times;</button>
                        </div>
                        <form class="form-horizontal" action="{{ route('pengurusan.peperiksaan.jadual_peperiksaan.add_subjek', $id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="modal-body">
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('subjek', 'Subjek', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('subjek', $subjects, null, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('subjek') ? 'is-invalid':''), 'data-control'=>'select2' ]) }}
                                                @error('subjek') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('tarikh', 'Tarikh', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('tarikh', old('tarikh'),['class' => 'form-control form-control-sm '.($errors->has('tarikh') ? 'is-invalid':''), 'id' =>'tarikh','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('tarikh') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('masa_mula', 'Masa Mula', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                <input type="time" id="masa_mula" name="masa_mula" class="form-control form-control-sm">
                                                @error('masa_mula') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('masa_tamat', 'Masa Tamat', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                <input type="time" id="masa_tamat" name="masa_tamat" class="form-control form-control-sm">
                                                @error('masa_tamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('bil_calon', 'Bilangan Calon', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::number('bil_calon', old('bil_calon') ,['class' => 'form-control form-control-sm', 'id' =>'nama','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('bil_calon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('lokasi', 'Lokasi', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('lokasi', $locations, null, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('lokasi') ? 'is-invalid':''), 'data-control'=>'select2' ]) }}
                                                @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            Simpan
                                        </button>
                                        <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Batal</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
            <!--end::Row-->
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function remove(id){
            Swal.fire({
                title: 'Are you sure you want to delete this file?',
                text: 'This action cannot be undone.',
                showCancelButton: true,
                cancelButtonText: 'Cancel',
                confirmButtonText: 'Delete',
                reverseButtons: true,
                customClass: {
                    title: 'swal-modal-delete-title',
                    htmlContainer: 'swal-modal-delete-container',
                    cancelButton: 'btn btn-light btn-sm mr-1',
                    confirmButton: 'btn btn-primary btn-sm ml-1'
                },
                buttonsStyling: false
            })
                .then((result) => {
                    if(result.isConfirmed){
                        document.getElementById(`delete-${id}`).submit();
                    }
                })
        }

        const { createApp } = Vue

        createApp({
        data() {
            return {}
        }
        }).mount('#advanceSearch')

        $("#tarikh").daterangepicker({
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
            $("#tarikh").val(datePicked);
        });

    </script>

    {!! $dataTable->scripts() !!}
@endpush

