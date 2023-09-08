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
                                <form class="form" action="{{ $action }}" method="post">
                                    @csrf

                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('program_pengajian', 'Program Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('program_pengajian', $courses, Request::get('program_pengajian'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                                @error('program_pengajian') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('sesi_peperiksaan', 'Sesi Peperiksaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('sesi_peperiksaan', $exam_sessions, Request::get('sesi_peperiksaan'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                                @error('sesi_peperiksaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('syukbah', 'Syukbah', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('syukbah', $syukbah, Request::get('syukbah'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                                @error('sesi_peperiksaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('semester_pengajian', 'Semester Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('semester_pengajian', $semesters, Request::get('semester_pengajian'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                                @error('semester_pengajian') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('pusat_pengajian', 'Pusat Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('pusat_pengajian', $campuses, Request::get('pusat_pengajian'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2' ]) }}
                                                @error('pusat_pengajian') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('kelas', 'Kelas', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('kelas', $classes, Request::get('kelas'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2' ]) }}
                                                @error('kelas') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('jantina', 'Jantina', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('jantina', $genders, Request::get('jantina'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2' ]) }}
                                                @error('jantina') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row mt-3">
                                        <div class="col-md-9 offset-md-3">
                                            <div class="d-flex">
                                                <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                    <i class="fa fa-save" style="vertical-align: initial"></i>Cetak
                                                </button>
                                                <a href="{{ route('pengurusan.peperiksaan.cetak_keputusan_penuh.index') }}" class="btn btn-sm btn-light">Batal</a>
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

