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
                        <form class="form" action="{{ $action }}" method="POST">
                            @csrf
                            @if($model->id) @method('PUT') @endif
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama_pelajar', 'Nama Penuh', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_pelajar', $model->pelajar->nama ?? '' ,['class' => 'form-control form-control-sm disabled', 'id' =>'nama_pelajar','onkeydown' =>'return false','autocomplete' => 'off']) }}

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('no_kad_pengenalan', 'No. Kad Pengenalan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('no_kad_pengenalan', $model->pelajar->no_ic ?? '' ,['class' => 'form-control form-control-sm disabled', 'id' =>'no_kad_pengenalan','onkeydown' =>'return false','autocomplete' => 'off']) }}

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('no_matrik', 'No. Matrik', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('no_matrik', $model->pelajar->no_matrik ?? '' ,['class' => 'form-control form-control-sm disabled', 'id' =>'no_kad_pengenalan','onkeydown' =>'return false','autocomplete' => 'off']) }}

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('program', 'Program', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('program', $model->pelajar->kursus->nama ?? '' ,['class' => 'form-control form-control-sm disabled', 'id' =>'program','onkeydown' =>'return false','autocomplete' => 'off']) }}

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('semester', 'Semester', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('semester', $model->semester->nama ?? '' ,['class' => 'form-control form-control-sm disabled', 'id' =>'semester','onkeydown' =>'return false','autocomplete' => 'off']) }}

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('syukbah_asal', 'Syukbah Asal', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('syukbah_asal', $model->oldSyukbah->nama ?? '' ,['class' => 'form-control form-control-sm disabled', 'id' =>'semester','onkeydown' =>'return false','autocomplete' => 'off']) }}

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('syukbah_pilihan', 'Syukbah Pilihan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('syukbah_pilihan', $model->newSyukbah->nama ?? '' ,['class' => 'form-control form-control-sm disabled', 'id' =>'semester','onkeydown' =>'return false','autocomplete' => 'off']) }}

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('sebab_tukar', 'Sebab Pertukaran Syukbah', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('sebab_tukar',$model->sebab_tukar ?? '',['class' => 'form-control form-control-sm disabled', 'rows'=>'6', 'onkeydown' =>'return false','autocomplete' => 'off']) }}

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh', 'Tarikh', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh', App\Helpers\Utils::formatDate($model->created_at) ?? '' ,['class' => 'form-control form-control-sm disabled', 'id' =>'semester','onkeydown' =>'return false','autocomplete' => 'off']) }}

                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('keputusan', 'Keputusan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('keputusan', $results, $model->status, ['placeholder' => 'Pilih Keputusan','class' =>'form-contorl form-select form-select-sm', 'data-control'=>'select2' ]) }}
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="pelajar_id" value="{{ $model->pelajar_id ?? null}}">
                            <input type="hidden" name="new_syukbah_id" value="{{ $model->new_syukbah_id ?? null }}">
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pengurusan.akademik.permohonan.pertukaran_syukbah.index') }}" class="btn btn-sm btn-light">Kembali</a>
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