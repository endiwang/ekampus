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
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('kelas', 'Kelas', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="mt-2">{{ $data->kelas->nama ?? null }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('program_pengajian', 'Program Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="mt-2">{{ $data->kursus->nama ?? null }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('subjek', 'Subjek', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="mt-2">{{ $data->subjek->nama ?? null }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('pensyarah', 'Pensyarah', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="mt-2">{{ $data->pensyarah->nama ?? null }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('pelajar', 'Nama Pelajar', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="mt-2">{{ $student->nama ?? null }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('no_matrik', 'No Matrik Pelajar', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="mt-2">{{ $student->no_matrik ?? null }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('clo', 'CLO', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="mt-2">{{ $data->clo->name ?? null }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('plo', 'PLO', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="mt-2">{{ $data->plo->name ?? null }}</p>
                                </div>
                            </div>
                        </div> 
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card" id="advanceSearch">
                    <div class="card-body py-5">
                        <form class="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 ">
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('clo', 'Markah CLO', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::number('clo', $model->clo_marks ?? old('clo') ,['class' => 'form-control form-control-sm', 'id' =>'clo','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('clo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>       
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('plo', 'Markah PLO', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::number('plo', $model->plo_marks ?? old('plo') ,['class' => 'form-control form-control-sm', 'id' =>'plo','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('plo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div> 
                                    <input type="hidden" name="clo_plo_id" value="{{ $data->id }}">
                                    <input type="hidden" name="student_id" value="{{ $student_id}}">
                                    <input type="hidden" name="class_id" value="{{ $class_id}}">   
                                    <input type="hidden" name="kursus_id" value="{{ $data->program_pengajian_id ?? null }}"> 
                                    <input type="hidden" name="semester_terkini_id" value="{{ $data->kelas->semasa_semester_id ?? null}}">   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 text-md-end">
                                    
                                </div>
                                <div class="col-md-9">
                                    <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                        <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                    </button>
                                    <a href="{{ route('pengurusan.akademik.pengurusan_jabatan.daftar_markah_clo_plo.show', $clo_plo_id) }}" class="btn btn-sm btn-light">Batal</a>
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
