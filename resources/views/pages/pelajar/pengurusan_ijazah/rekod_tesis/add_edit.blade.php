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
                                    {{ Form::label('nama_projek', 'Nama Projek', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_projek', $model->project_name ?? old('nama_projek') ,['class' => 'form-control form-control-sm', 'id' =>'nama_projek','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('nama_projek') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tajuk_tesis', 'Tajuk Tesis/Projek Ilmiah', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tajuk_tesis',$model->project_title ?? old('tajuk_tesis') ,['class' => 'form-control form-control-sm '.($errors->has('tajuk_tesis') ? 'is-invalid':''), 'id' =>'tajuk_tesis', 'rows'=>'3']) }}
                                        @error('tajuk_tesis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama_fail', 'Nama Fail Projek Ilmiah', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    {{ Form::text('nama_fail', $model->file_name ?? old('nama_fail') ,['class' => 'form-control form-control-sm', 'id' =>'nama_fail','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('file', 'Muat Naik Projek Ilmiah', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="file" class="form-control form-control-sm" name="file"  accept=".pdf">
                                        @error('file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            @if(!empty($model->id))
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <a href='{{ !empty($model->uploaded_document)?asset($model->uploaded_document):'' }}'target='_blank'>{{ $model->uploaded_document ?? 'View Document'}}</a>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('keterangan_dokumen', 'Keterangan Dokumen', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('keterangan_dokumen',$model->description ?? old('keterangan_dokumen') ,['class' => 'form-control form-control-sm '.($errors->has('keterangan_dokumen') ? 'is-invalid':''), 'id' =>'keterangan_dokumen', 'rows'=>'3']) }}
                                        @error('keterangan_dokumen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pelajar.pengurusan_ijazah.rekod_tesis.index') }}" class="btn btn-sm btn-light">Batal</a>
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

@endpush
