@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card" id="advanceSearch">
                    <div class="card-header">
                        <h3 class="card-title">Pilih Jenis Keahlian</h3>
                    </div>
                    <div class="card-body py-5">
                        <div class="d-flex flex-equal gap-5 gap-xxl-9 px-0 mb-12" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]" data-kt-initialized="1">
                            <!--begin::Radio-->
                            <label id="pelajar" class="btn bg-light-success hover-elevate-up btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-100 border-active-primary btn-active-light-primary w-100 px-4" data-kt-button="true" onc>
                                <!--begin::Input-->
                                <input class="btn-check" type="radio" name="method" value="0">
                                <!--end::Input-->
                                <!--begin::Icon-->
                                <i class=" fa fa-user-graduate fs-2hx mb-2 pe-0"></i>
                                <!--end::Icon-->
                                <!--begin::Title-->
                                <span class="fs-7 fw-bold d-block">Pelajar</span>
                                <!--end::Title-->
                            </label>
                            <!--end::Radio-->
                            <!--begin::Radio-->
                            <label id="kakitangan" class="btn bg-light-warning hover-elevate-up btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-100 border-active-success btn-active-light-primary w-100 px-4" data-kt-button="true">
                                <!--begin::Input-->
                                <input class="btn-check" type="radio" name="method" value="1">
                                <!--end::Input-->
                                <!--begin::Icon-->
                                <i class=" fa fa-users fs-2hx mb-2 pe-0"></i>
                                <!--end::Icon-->
                                <!--begin::Title-->
                                <span class="fs-7 fw-bold d-block">Kakitangan</span>
                                <!--end::Title-->
                            </label>
                            <!--end::Radio-->
                            <!--begin::Radio-->
                            <label id="awam" class="btn bg-light-primary hover-elevate-up btn-color-gray-600 btn-active-text-gray-800 border border-3 border-gray-100 border-active-success btn-active-light-primary w-100 px-4" data-kt-button="true">
                                <!--begin::Input-->
                                <input class="btn-check" type="radio" name="method" value="1">
                                <!--end::Input-->
                                <!--begin::Icon-->
                                <i class=" fa fa-user fs-2hx mb-2 pe-0"></i>
                                <!--end::Icon-->
                                <!--begin::Title-->
                                <span class="fs-7 fw-bold d-block">Orang Awam</span>
                                <!--end::Title-->
                            </label>
                            <!--end::Radio-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card" id="advanceSearch">

                    <div class="card-body py-5">
                        <p>
                        {{-- <form class="form" action="{{ $action }}" method="post"> --}}
                            <div style="display: none" id="form_awam">
                                <form class="form" action="{{ $action }}" method="post">
                                @if($model->id) @method('PUT') @endif
                                @csrf
                                    <div class="fs-4 fw-bold text-gray-800 text-center mb-13">
                                        <span class="me-2">{{ $page_title }}<br> Orang Awam </span>
                                    </div>

                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('nama', 'Nama', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('nama', $model->nama ?? old('nama'),['class' => 'form-control form-control-sm '.($errors->has('nama') ? 'is-invalid':''), 'id' =>'nama','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('ic_no', 'No IC', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('ic_no', $model->ic_no ?? old('ic_no'),['class' => 'form-control form-control-sm '.($errors->has('ic_no') ? 'is-invalid':''), 'id' =>'ic_no','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('ic_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('no_telefon', 'No Telefon', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::text('no_telefon', $model->no_telefon ?? old('no_telefon'),['class' => 'form-control form-control-sm '.($errors->has('no_telefon') ? 'is-invalid':''), 'id' =>'no_telefon','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                                @error('no_telefon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                {!! Form::hidden('is_public', 1, ['class' => '']) !!}
                                                {!! Form::hidden('type', 'awam', ['class' => '']) !!}

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-9 offset-md-3">
                                            <div class="d-flex">
                                                <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                    <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                                </button>
                                                <a href="{{ route('pengurusan.perpustakaan.keahlian.index') }}" class="btn btn-sm btn-light">Batal</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div style="display: none" id="form_pelajar">
                                <form class="form" action="{{ $action }}" method="post">
                                    @if($model->id) @method('PUT') @endif
                                    @csrf
                                    <div class="fs-4 fw-bold text-gray-800 text-center mb-13">
                                        <span class="me-2">{{ $page_title }}<br> Pelajar </span>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('pelajar_id', 'No Ic Pelajar', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('pelajar_id', $pelajar, Request::get('pelajar_id'), ['placeholder' => 'Sila Pilih','class' =>'form-select form-select-sm', 'data-control'=>'select2', 'required' => 'required' ]) }}
                                                @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                {!! Form::hidden('type', 'pelajar', ['class' => '']) !!}

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-9 offset-md-3">
                                            <div class="d-flex">
                                                <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                    <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                                </button>
                                                <a href="{{ route('pengurusan.perpustakaan.keahlian.index') }}" class="btn btn-sm btn-light">Batal</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div style="display: none" id="form_kakitangan">
                                <form class="form" action="{{ $action }}" method="post">
                                    @if($model->id) @method('PUT') @endif
                                    @csrf
                                    <div class="fs-4 fw-bold text-gray-800 text-center mb-13">
                                        <span class="me-2">{{ $page_title }}<br> Kakitangan </span>
                                    </div>
                                    <div class="row fv-row mb-2" >
                                        <div class="col-md-3 text-md-end">
                                            {{ Form::label('staff_id', 'No Ic Kakitangan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                        </div>
                                        <div class="col-md-9">
                                            <div class="w-100">
                                                {{ Form::select('staff_id', $kakitangan, Request::get('staff_id'), ['placeholder' => 'Sila Pilih','class' =>'form-select form-select-sm', 'data-control'=>'select2', 'required' => 'required' ]) }}
                                                @error('staff_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                {!! Form::hidden('type', 'staff', ['class' => '']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" style="display: none" id="submit">
                                        <div class="col-md-9 offset-md-3">
                                            <div class="d-flex">
                                                <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                    <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                                </button>
                                                <a href="{{ route('pengurusan.perpustakaan.keahlian.index') }}" class="btn btn-sm btn-light">Batal</a>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        {{-- </form> --}}

                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function(){

        $("#pelajar").click(function(){
            $("#form_pelajar").show();
            $("#submit").show();
            $("#form_awam").hide();
            $("#form_kakitangan").hide();
        });


        $("#kakitangan").click(function(){
            $("#form_kakitangan").show();
            $("#submit").show();
            $("#form_pelajar").hide();
            $("#form_awam").hide();
        });

        $("#awam").click(function(){
            $("#form_awam").show();
            $("#submit").show();
            $("#form_pelajar").hide();
            $("#form_kakitangan").hide();


        });
    });
    </script>

@endpush
