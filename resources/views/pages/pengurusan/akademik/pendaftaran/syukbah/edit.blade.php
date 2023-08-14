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
                        <form class="form" action="{{ $action }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama_pelajar', 'Nama Penuh', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_pelajar', $model->nama ?? '' ,['class' => 'form-control form-control-sm disabled', 'id' =>'nama_pelajar','onkeydown' =>'return false','autocomplete' => 'off']) }}

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('no_kad_pengenalan', 'No. Kad Pengenalan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('no_kad_pengenalan', $model->no_ic ?? '' ,['class' => 'form-control form-control-sm disabled', 'id' =>'no_kad_pengenalan','onkeydown' =>'return false','autocomplete' => 'off']) }}

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('no_matrik', 'No. Matrik', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('no_matrik', $model->no_matrik ?? '' ,['class' => 'form-control form-control-sm disabled', 'id' =>'no_kad_pengenalan','onkeydown' =>'return false','autocomplete' => 'off']) }}

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('sesi_pengajian', 'Sesi Pengajian', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('sesi_pengajian', $model->sesi->nama ?? '' ,['class' => 'form-control form-control-sm disabled', 'id' =>'sesi_pengajian','onkeydown' =>'return false','autocomplete' => 'off']) }}

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('program', 'Program', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('program', $model->kursus->nama ?? '' ,['class' => 'form-control form-control-sm disabled', 'id' =>'program','onkeydown' =>'return false','autocomplete' => 'off']) }}

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('alamat', 'Alamat Rumah (Surat Menyurat)', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('alamat', $model->alamat ?? '' ,['class' => 'form-control form-control-sm disabled', 'id' =>'alamat','onkeydown' =>'return false','autocomplete' => 'off']) }}

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('poskod', 'Poskod', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('poskod', $model->poskod ?? '' ,['class' => 'form-control form-control-sm disabled', 'id' =>'poskod','onkeydown' =>'return false','autocomplete' => 'off']) }}

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('negeri', 'Negeri', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('negeri', $model->negeri ?? '' ,['class' => 'form-control form-control-sm disabled', 'id' =>'negeri','onkeydown' =>'return false','autocomplete' => 'off']) }}

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('no_tel', 'No.Telefon (Rumah)', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('no_tel', $model->no_tel ?? '' ,['class' => 'form-control form-control-sm disabled', 'id' =>'no_tel','onkeydown' =>'return false','autocomplete' => 'off']) }}

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('no_hp', 'No.Telefon (Bimbit)', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('no_hp', $model->no_hp ?? '' ,['class' => 'form-control form-control-sm disabled', 'id' =>'no_hp','onkeydown' =>'return false','autocomplete' => 'off']) }}

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('syukbah', 'Syukbah', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('syukbah', $syukbah, $model->syukbah_id, ['placeholder' => 'Pilih Syukbah','class' =>'form-contorl form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" value="{{ $model->kursus_id }}" name="kursus_id">
                            <input type="hidden" value="{{ $model->sesi_id }}" name="sesi_id">
                            <input type="hidden" value="{{ $model->id }}" name="id_pelajar">
                    
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Daftar
                                        </button>
                                        <a href="{{ route('pengurusan.akademik.syukbah_pelajar.index') }}" class="btn btn-sm btn-light">Batal</a>
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