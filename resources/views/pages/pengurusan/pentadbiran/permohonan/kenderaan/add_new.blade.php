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
                        <form class="form" action="{{url('pengurusan/pentadbiran/kenderaan/permohonan/update')}}" method="post" enctype="multipart/form-data">
                        
                    @else
                        <form class="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                        
                        
                    @endif
                            @csrf
                            @if($model->id) @method('POST') <input type="hidden" name="id" value="{{data_get($model,'id')}}" /> @endif
                            
                            


                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jenis_kenderaan', 'Kenderaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        
                                        {{ Form::select('jenis_kenderaan', $selectkenderaan, $model->jenis_kenderaan, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('bilik') ? 'is-invalid':'') ]) }}                                                                                
                                        @error('jenis_kenderaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_penggunaan', 'Tarikh Penggunaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::date('tarikh_penggunaan', $model->tarikh_penggunaan ?? '' ,['class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('tarikh_penggunaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('masa', 'Masa', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::time('masa', $model->masa ?? '' ,['class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('masa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>                                                                                                                        
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tempat', 'Tempat', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tempat', $model->tempat ?? '' ,['class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('tempat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tujuan', 'Tujuan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tujuan', $model->tujuan ?? '' ,['class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('tujuan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>  
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('bil_penumpang', 'Bil Penumpang', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::number('bil_penumpang', $model->tempat ?? '' ,['class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('bil_penumpang') <div class="invalid-feedback">{{ $message }}</div> @enderror
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