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
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('nama_kandungan', 'Nama Kandungan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('nama_kandungan', $model->nama ?? old('nama_kandungan'),['class' => 'form-control form-control-sm '.($errors->has('nama_kandungan') ? 'is-invalid':''), 'id' =>'nama_kandungan','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('nama_kandungan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('kursus', 'Kursus', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                <select class="form-control form-select form-select-sm" data-control="select2" name="kursus" id="kursus">
                                                    <option value="">Pilih Kursus</option>
                                                    @foreach($subjects as $subject)
                                                    <option value="{{ $subject->id }}" @if(!empty($model->subjek_id) && $model->subjek_id == $subject->id) selected @endif>{{ $subject->kod_subjek }} - {{ $subject->nama }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('penerangan', 'Penerangan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                <textarea class="form-control" id="tinymce" name="penerangan">{{ $model->penerangan ?? old('body') }}</textarea>
                                                @error('penerangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
        
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('status', 'Status', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                <label class="form-check form-switch form-check-custom form-check-solid">
                                                    {{ Form::checkbox('status', '0', ($model->status == 0 ? true:false), ['class' => 'form-check-input h-25px w-60px']); }}
                                                    <span class="form-check-label fs-7 fw-semibold mt-2">
                                                        Aktif
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>        

                                    <div class="row mt-3">
                                        <div class="col-md-9 offset-md-3">
                                            <div class="d-flex">
                                                <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                    <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                                </button>
                                                <a href="{{ route('pengurusan.akademik.e_learning.pengurusan_kandungan.index') }}" class="btn btn-sm btn-light">Batal</a>
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
                                    <h5 class="fw-bold">Fail-fail Kandungan Pembelajaran</h5>
                                </div>
                                <div class="col-lg-6" style="text-align: right">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#tambahFail" class="btn btn-sm btn-primary fw-bold" title="Tambah Fail Laporan Mesyuarat">
                                        <i class="fa fa-plus-circle" style="vertical-align: initial"></i>Tambah Kandungan Pembelajaran
                                    </a>
                                </div>
                            </div>
                            {{ $dataTable->table(['class'=>'table table-striped table-row-bordered gy-5 gs-7 border rounded']) }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="tambahFail" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Tambah Kandungan Pembelajaran</h3>
                            <button type="button" class="close btn btn-sm btn-default" data-bs-dismiss="modal">&times;</button>
                        </div>
                        <form class="form-horizontal" action="{{ route('pengurusan.akademik.e_learning.pengurusan_kandungan.upload_file', $id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                                <div class="modal-body">
                                    
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('file_name', 'Nama Fail', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('file_name', old('file_name'),['class' => 'form-control form-control-sm '.($errors->has('file_name') ? 'is-invalid':''), 'id' =>'file_name','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('file_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('type', 'Jenis Kandungan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('type', $types, null, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2' ]) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('file', 'Pilih Dokumen', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                <input type="file" name="file" class="form-control form-control-sm">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('status', 'Status', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                <select class="form-control form-select form-select-sm" data-control="select2" name="status">
                                                    <option data-display="Status*" value="">Status *</option>
                                                    <option value="1">Aktif</option> 
                                                    <option value="0">Tidak Aktif</option> 
                                                </select>
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
        tinymce.init({
            selector: 'textarea#tinymce',
            height: 400
        });

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
            return {
                table: null,
            }
        },
        methods: {
            },
        mounted() {

            },
        }).mount('#advanceSearch')
    </script>

    {!! $dataTable->scripts() !!}

@endpush