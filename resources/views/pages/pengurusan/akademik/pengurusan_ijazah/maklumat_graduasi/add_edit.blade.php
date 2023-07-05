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
                                    {{ Form::label('nama_dokumen', 'Nama Dokumen', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_dokumen', $model->file_name ?? old('nama_dokumen') ,['class' => 'form-control form-control-sm', 'id' =>'nama_dokumen','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('nama_dokumen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('keterangan', 'Keterangan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('keterangan',$model->description ?? old('keterangan') ,['class' => 'form-control form-control-sm '.($errors->has('keterangan') ? 'is-invalid':''), 'id' =>'keterangan', 'rows'=>'3']) }}
                                        @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jenis_dokumen', 'Jenis Dokumen', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    {{ Form::select('jenis_dokumen', $types, $model->document_type ?? old('jenis_dokumen'), ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ', 'data-control'=>'select2']) }}
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('dokumen_graduasi', 'Dokumen Maklumat Graduasi', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
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
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pengurusan.akademik.pengurusan_ijazah.maklumat_graduasi.index') }}" class="btn btn-sm btn-light">Batal</a>
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
