@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
             <!--begin::Row-->
             <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <form class="form" action="{{ route('pengurusan.peperiksaan.cetak_tuntutan_bayaran.download')}}" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-body py-5">
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('program_pengajian', 'Program Pengajian', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('program_pengajian', $courses, Request::get('program_pengajian'), ['data-control'=>'select2', 'placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm','id'=>'program_pengajian' ]) }}
                                            {{-- <select class="form-control form-select form-select-sm" data-control="select2" v-model="selectedCourse" @change="getSession">
                                                <option value="">Pilih Program Pengajian</option>
                                                <option v-for="course in courses" :key="course.id" :value="course.id">@{{ course.nama }}</option>
                                            </select> --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('pusat_pengajian', 'Pusat Pengajian', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('pusat_pengajian', $campuses, Request::get('pusat_pengajian'), ['data-control'=>'select2', 'placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm','id'=>'pusat_pengajian' ]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('sesi', 'Sesi Peperiksaan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('sesi', $sessions, Request::get('sesi'), ['data-control'=>'select2', 'placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm','id'=>'sesi' ]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('semester_pengajian', 'Semester Pengajian', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('semester_pengajian', $semesters, Request::get('semester_pengajian'), ['data-control'=>'select2', 'placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm','id'=>'semester_pengajian' ]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('kelas', 'Kelas', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('kelas', $classes, Request::get('kelas'), ['data-control'=>'select2', 'placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm','id'=>'kelas' ]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <button id="kt_share_earn_link_copy_button" class="btn btn-success btn-sm fw-bold flex-shrink-0 me-3" name="jenis" value="1">
                                                <i class="fa-solid fa-circle-down" style="vertical-align: initial"></i>Cetak Tuntutan Bayaran (Sebelum)
                                            </button>
                                            <button id="kt_share_earn_link_copy_button" class="btn btn-success btn-sm fw-bold flex-shrink-0 me-3" name="jenis" value="2">
                                                <i class="fa-solid fa-circle-down" style="vertical-align: initial"></i>Cetak Tuntutan Bayaran
                                            </button>
                                            <a href="{{ route('pengurusan.peperiksaan.cetak_tuntutan_bayaran.index') }}" class="btn btn-sm btn-light">Set Semula</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--end::Row-->
        </div>
    </div>
@endsection

@push('scripts')

@endpush
