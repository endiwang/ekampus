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
                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kod_kursus', 'Status', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <select class="form-control form-select form-select-sm" data-control="select2" name="kod_kursus" id="kod_kursus">
                                        <option value="">Pilih Status</option>
                                        @foreach($statuses as $status)
                                        <option value="{{ $status['kod'] }}" @if(!empty($model->kod) && $status['kod'] == $model->kod) selected @endif>{{ $status['nama'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama_pengajian', 'Nama Pengajian', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_pengajian', $model->nama ?? old('nama_pengajian') ,['class' => 'form-control form-control-sm', 'id' =>'nama_pengajian','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('nama_pengajian') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('maklumat_cetakan', 'Maklumat Cetakan', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('maklumat_cetakan', $model->maklumat_cetakan ?? old('maklumat_cetakan') ,['class' => 'form-control form-control-sm', 'id' =>'maklumat_cetakan','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jumlah_semester', 'Jumlah Semester', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::number('jumlah_semester', $model->bil_sem_keseluruhan ?? old('jumlah_semester') ,['class' => 'form-control form-control-sm', 'id' =>'jumlah_semester','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                       
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('semester_setahun', 'Jumlah Semester Setahun', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('semester_setahun', $yearly_semesters, $model->bil_sem_setahun ?? old('semester_setahun'), ['data-control'=>'select2', 'placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm','id'=>'subjek' ]) }}

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status', 'Status', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
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
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('paparan_log_masuk', 'Paparan Log Masuk', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('paparan_log_masuk', $views, $model->is_paparan_login ?? old('paparan_log_masuk'), ['data-control'=>'select2', 'placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm','id'=>'paparan_log_masuk' ]) }}
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pengurusan.peperiksaan.kemaskini.senarai_kursus.index') }}" class="btn btn-sm btn-light">Batal</a>
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
