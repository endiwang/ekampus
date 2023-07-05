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
                            {{--<div class="row fv-row mb-2">
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
                                        @foreach($subjects as $key => $value)
                                        <option value="{{ $key }}" @if(!empty($model->subjek_id) && $key == $model->subjek_id) selected @endif>{{ $value }}</option>
                                        @endforeach
                                    </select>
                                    @error('subjek') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>--}}
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tajuk', 'Tajuk', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tajuk', $model->name ?? old('tajuk') ,['class' => 'form-control form-control-sm', 'id' =>'tajuk','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('tajuk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('keterangan', 'Keterangan', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('keterangan', $model->description ?? old('keterangan') ,['class' => 'form-control form-control-sm', 'id' =>'keterangan','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pengurusan.akademik.pengurusan_jabatan.pengurusan_clo.index') }}" class="btn btn-sm btn-light">Batal</a>
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
