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
                        <div class="card-body py-5">
                            <div class="row fv-row mb-2" >
                                <form class="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @if($model->id) @method('PUT') @endif
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('nama', 'Nama Pelajar', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('nama', $model->nama ?? null,['class' => 'form-control form-control-sm disabled', 'id' =>'nama','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('no_ic', 'No. Kad Pengenalan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('no_ic', $model->no_ic ?? null,['class' => 'form-control form-control-sm disabled', 'id' =>'no_ic','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('no_matrik', 'No. Matrik', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('no_matrik', $model->no_matrik ?? null,['class' => 'form-control form-control-sm disabled', 'id' =>'no_matrik','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('sesi', 'Sesi Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('sesi', $model->sesi->nama ?? null,['class' => 'form-control form-control-sm disabled', 'id' =>'sesi','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('program', 'Program Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('program', $model->kursus->nama ?? null,['class' => 'form-control form-control-sm disabled', 'id' =>'program','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('syukbah', 'Syukbah', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('syukbah', $model->syukbah->nama ?? null,['class' => 'form-control form-control-sm disabled', 'id' =>'syukbah','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('alamat', 'Alamat Rumah (Surat-menyurat)', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('alamat', $model->alamat ?? null,['class' => 'form-control form-control-sm disabled', 'id' =>'syukbah','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('poskod', 'Poskod', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('poskod', $model->poskod ?? null,['class' => 'form-control form-control-sm disabled', 'id' =>'poskod','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('bandar', 'Bandar', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('bandar', $model->bandar ?? null,['class' => 'form-control form-control-sm disabled', 'id' =>'bandar','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('negeri', 'Negeri', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('negeri', $model->negeri->nama ?? null,['class' => 'form-control form-control-sm disabled', 'id' =>'negeri','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('no_tel', 'No. Telefon (Rumah)', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('no_tel', $model->no_tel ?? null,['class' => 'form-control form-control-sm disabled', 'id' =>'no_tel','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('no_hp', 'No. Telefon (Bimbit)', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('no_hp', $model->no_hp ?? null,['class' => 'form-control form-control-sm disabled', 'id' =>'no_hp','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('status', 'Status Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('status', $statuses, $model->is_gantung, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('status') ? 'is-invalid':''), 'data-control'=>'select2' ]) }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-md-9 offset-md-3">
                                            <div class="d-flex">
                                                <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                    <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                                </button>
                                                <a href="{{ route('pengurusan.akademik.laporan.tangguh_pengajian.index') }}" class="btn btn-sm btn-light">Batal</a>
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