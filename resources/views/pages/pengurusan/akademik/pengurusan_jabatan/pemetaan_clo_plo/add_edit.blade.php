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
                                    {{ Form::label('program_pengajian', 'Program Pengajian', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <select class="form-control form-select form-select-sm" data-control="select2" name="program_pengajian" id="program_pengajian">
                                        <option value="">Pilih Program Pengajian</option>
                                        @foreach($courses as $key => $value)
                                        <option value="{{ $key }}" @if(!empty($model->program_pengajian_id) && $key == $model->program_pengajian_id) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('program_pengajian') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('subjek', 'Subjek', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <select class="form-control form-select form-select-sm" data-control="select2" name="subjek" id="subjek">
                                        <option value="">Pilih Subjek</option>
                                        @foreach($subjects as $subject)
                                        <option value="{{ $subject->id }}" @if(!empty($model->kursus_id) && $subject->id == $model->kursus_id) selected @endif>{{ $subject->kod_subjek . '-' . $subject->nama }}</option>
                                        @endforeach
                                    </select>
                                    @error('subjek') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kelas', 'Kelas', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <select class="form-control form-select form-select-sm" data-control="select2" name="kelas" id="kelas">
                                        <option value="">Pilih Kelas</option>
                                        @foreach($classes as $key => $value)
                                        <option value="{{ $key }}" @if(!empty($model->kelas_id) && $key == $model->kelas_id) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('kelas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('pensyarah', 'Pensyarah', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <select class="form-control form-select form-select-sm" data-control="select2" name="pensyarah" id="pensyarah">
                                        <option value="">Pilih Pensyarah</option>
                                        @foreach($lecturers as $key => $value)
                                        <option value="{{ $key }}" @if(!empty($model->pensyarah_id) && $key == $model->pensyarah_id) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('pensyarah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('clo', 'CLO', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <select class="form-control form-select form-select-sm" data-control="select2" name="clo" id="clo">
                                        <option value="">Pilih CLO</option>
                                        @foreach($clos as $key => $value)
                                        <option value="{{ $key }}" @if(!empty($model->clo_id) && $key == $model->clo_id) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('clo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('plo', 'PLO', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <select class="form-control form-select form-select-sm" data-control="select2" name="plo" id="plo">
                                        <option value="">Pilih CLO</option>
                                        @foreach($plos as $key => $value)
                                        <option value="{{ $key }}" @if(!empty($model->plo_id) && $key == $model->plo_id) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('plo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('markah', 'Peratus Pemarkahan (%)', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('markah', number_format($model->marks,2) ?? old('markah') ,['class' => 'form-control form-control-sm', 'id' =>'markah','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('markah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pengurusan.akademik.pengurusan_jabatan.pemetaan_clo_plo.index') }}" class="btn btn-sm btn-light">Batal</a>
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
