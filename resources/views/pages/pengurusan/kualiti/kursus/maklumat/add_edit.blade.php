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
                    @if($model->id)
                        <form class="form" action="{{url('pengurusan/kualiti/maklumat/kursus/peserta/update')}}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="kursusid" value="{{data_get($model,'fk_kursus_dan_latihan')}}" />
                    @else
                        <form class="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="kursusid" value="{{Request::segment(5)}}" />
                        
                    @endif
                            @csrf
                            @if($model->id) @method('POST') <input type="hidden" name="id" value="{{data_get($model,'id')}}" /> @endif
                            
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('name', 'Nama', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('name', $model->nama ?? '' ,['class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('noic', 'No Kad Pengenalan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::number('noic', $model->noic ?? '' ,['class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('noic') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('course', 'Maklumat Kursus', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('course', $model->maklumat_kursus ?? '' ,['class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('course') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('year', 'Tahun', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::number('year', $model->tahun ?? '' ,['class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('year') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            
                            
                
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <!-- <a href="/pengurusan/kualiti/maklumat/kursus/{{Request::segment(5)}}/list" class="btn btn-sm btn-light">Batal</a> -->
                                        <a class="btn btn-sm btn-light" onclick="history.back()">Batal</a>
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