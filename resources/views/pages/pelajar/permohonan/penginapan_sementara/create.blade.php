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
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama_institusi', 'Nama Institusi', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_institusi', old('nama_institusi'),['class' => 'form-control form-control-sm '.($errors->has('nama_institusi') ? 'is-invalid':''), 'id' =>'nama_institusi','onkeydown' =>'return true','autocomplete' => 'off','required' => 'required']) }}
                                        @error('nama_institusi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tujuan', 'Tujuan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tujuan', old('tujuan'),['class' => 'form-control required form-control-sm '.($errors->has('tujuan') ? 'is-invalid':''), 'id' =>'tujuan','onkeydown' =>'return true','autocomplete' => 'off', 'required' => 'required']) }}
                                        @error('tujuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama_pelajar', 'Nama Pelajar', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_pelajar', old('nama_pelajar'),['class' => 'form-control form-control-sm '.($errors->has('nama_pelajar') ? 'is-invalid':''), 'id' =>'nama_pelajar','onkeydown' =>'return true','autocomplete' => 'off','required' => 'required']) }}
                                        @error('nama_pelajar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('mykad', 'MyKad', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('mykad', old('mykad'),['class' => 'form-control form-control-sm '.($errors->has('mykad') ? 'is-invalid':''), 'id' =>'mykad','onkeydown' =>'return true','autocomplete' => 'off','required' => 'required']) }}
                                        @error('mykad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('no_tel', 'No Telefon', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('no_tel', old('no_tel'),['class' => 'form-control form-control-sm '.($errors->has('no_tel') ? 'is-invalid':''), 'id' =>'no_tel','onkeydown' =>'return true','autocomplete' => 'off','required' => 'required']) }}
                                        @error('no_tel') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('program_id', 'Program', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('program_id', $kursus , old('program_id') , ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2', 'required' => 'required' ]) }}
                                        @error('program_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('semester_id', 'Semester', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('semester_id', $semester , old('semester_id') , ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2', 'required' => 'required' ]) }}
                                        @error('semester_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama_ibu_bapa_penjaga', 'Nama Ibu / Bapa / Penjaga', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_ibu_bapa_penjaga', old('nama_ibu_bapa_penjaga'),['class' => 'form-control form-control-sm '.($errors->has('nama_ibu_bapa_penjaga') ? 'is-invalid':''), 'id' =>'nama_ibu_bapa_penjaga','onkeydown' =>'return true','autocomplete' => 'off','required' => 'required']) }}
                                        @error('nama_ibu_bapa_penjaga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('no_tel_ibu_bapa_penjaga', 'No Telefon Ibu / Bapa / Penjaga', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('no_tel_ibu_bapa_penjaga', old('no_tel_ibu_bapa_penjaga'),['class' => 'form-control form-control-sm '.($errors->has('no_tel_ibu_bapa_penjaga') ? 'is-invalid':''), 'id' =>'no_tel_ibu_bapa_penjaga','onkeydown' =>'return true','autocomplete' => 'off','required' => 'required']) }}
                                        @error('no_tel_ibu_bapa_penjaga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pelajar.permohonan.bawa_barang.index') }}" class="btn btn-sm btn-light">Batal</a>
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
<script>
    $("#bantuan_id").change(function(){
        if($("#bantuan_id").val() == 0)
        {
            $("#lain_lain").removeAttr('disabled', 'disabled');
            $("#lain_lain").val('');
        }else{
            $("#lain_lain").attr('disabled', 'disabled');
            $("#lain_lain").val('');
        }
    });
</script>

@endpush
