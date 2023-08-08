@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Sesi Pengajian</h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Utama</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Cawangan Kualiti</li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">Jaminan Kualiti</li>

                </ul>
            </div>
        </div>
    </div>
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="card" id="advanceSearch">
                        <div class="card-header">
                            <h3 class="card-title">Kemaskini Jaminan Kualiti</h3>
                        </div>
                        <div class="card-body py-5">
                            <form class="form" action="{{ route('pengurusan.kualiti.kualiti.update')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" value="{{$data->id}}" />
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('cat_mak_label', 'Kategori Maklumat', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('category', $catMaklumat, data_get($data,'lkp_kategori_maklumat'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('tahun_bermula') ? 'is-invalid':'') ]) }}
                                            @error('category') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('name', 'Nama Fail', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('name', data_get($data,'nama'),['class' => 'form-control form-control-sm '.($errors->has('name') ? 'is-invalid':''), 'id' =>'no_ic','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('description', 'Keterangan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('description', data_get($data,'keterangan'),['class' => 'form-control form-control-sm '.($errors->has('name') ? 'is-invalid':''), 'id' =>'no_ic','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('jenis_dok', 'Jenis Dokumen', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('docType', $jenisDoc, data_get($data,'jenis_dokumen'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('tahun_bermula') ? 'is-invalid':'') ]) }}
                                            @error('docType') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('dokumen', 'Muat Naik Jaminan Kualiti', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <input type="file" class="form-control form-control-sm" name="file"  accept=".pdf">
                                            @error('dokumen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <a href='{{ !empty($data->path)?asset($data->path):'' }}'target='_blank'>{{ $data->path ?? 'View Document'}}</a>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('status', 'Status', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                {{ Form::checkbox('status', '0', true, ['class' => 'form-check-input h-25px w-60px']); }}
                                                <span class="form-check-label fs-7 fw-semibold mt-2">
                                                    Aktif
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                        <div class="d-flex">
                                            <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                            </button>
                                            <a href="{{ url('pengurusan/kualiti/index') }}" class="btn btn-sm btn-light">Batal</a>
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
