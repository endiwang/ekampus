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
                        <form class="form" action="{{url('pengurusan/pentadbiran/pelekat/permohonan/update')}}" method="post" enctype="multipart/form-data">
                        
                    @else
                        <form class="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                        
                        
                    @endif
                            @csrf
                            @if($model->id) @method('POST') <input type="hidden" name="id" value="{{data_get($model,'id')}}" /> @endif
                            
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('no_permohonan', 'No Permohonan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('no_permohonan', $model->no_permohonan ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('no_permohonan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama', 'Pemohon', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        @if($model->user->is_student == 1)
                                        
                                        {{ Form::text('nama', data_get($model,'user.pelajar.0.nama') ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @elseif($model->user->staff !=NULL)
                                        {{ Form::text('nama', $model->user->staff->nama ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @else
                                        {{ Form::text('nama', data_get($model,'user.vendor.nama_syarikat') ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @endif
                                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            @if($model->user->is_student == 1)
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                {{ Form::label('dokumen', 'Surat Kelulusan HEP', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <a href='{{ !empty($model->upload_document)?asset($model->upload_document):'' }}'target='_blank'>{{ $model->document_name ?? 'View Document'}}</a>
                                    </div>
                                </div>
                            </div>
                            @elseif(data_get($model,'user.vendor.id') > 0)
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                {{ Form::label('dokumen', 'Surat Kelulusan Unit Pentadbiran', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <a href='{{ !empty($model->upload_document)?asset($model->upload_document):'' }}'target='_blank'>{{ $model->document_name ?? 'View Document'}}</a>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jenis_kenderaan', 'Jenis Kenderaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        
                                        {{ Form::select('jenis_kenderaan', $selectkenderaan, $model->jenis_kenderaan, ['disabled' => 'disabled','placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('bilik') ? 'is-invalid':'') ]) }}                                                                                
                                        @error('jenis_kenderaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jenama', 'Jenama', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('jenama', $model->jenama ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('jenama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('no_plate', 'No Kenderaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('no_plate', $model->no_plate ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('no_plate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>                                                                                                                        
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_tamat_cukai', 'Tarikh Tamat Cukai', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::date('tarikh_tamat_cukai', $model->tarikh_tamat_cukai ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('tarikh_tamat_cukai') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>  
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_tamat_lesen', 'Tarikh Tamat Lesen', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::date('tarikh_tamat_lesen', $model->tarikh_tamat_lesen ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('tarikh_tamat_lesen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div> 

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                {{ Form::label('dokumen_geran', 'Salinan Geran', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <a href='{{ !empty($model->upload_document_geran)?asset($model->upload_document_geran):'' }}'target='_blank'>{{ $model->document_name_geran ?? 'View Document'}}</a>
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                {{ Form::label('dokumen_surat_kuasa', 'Salinan Surat Kuasa Jika Bukan Penama', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <a href='{{ !empty($model->upload_document_surat_kuasa)?asset($model->upload_document_surat_kuasa):'' }}'target='_blank'>{{ $model->document_name_surat_kuasa ?? 'View Document'}}</a>
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                {{ Form::label('dokumen_lesen', 'Salinan Lesen Memandu', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <a href='{{ !empty($model->upload_document_lesen)?asset($model->upload_document_lesen):'' }}'target='_blank'>{{ $model->document_name_lesen ?? 'View Document'}}</a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status', 'Tindakan Kelulusan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                    @if(data_get($kakitangan,'staff.jabatan.id') == 14)

                                    {{ Form::select('status', $status, $model->status_permohonan, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('kategori') ? 'is-invalid':'') ]) }}
                                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror

                                    @else
                                        Maaf Anda bukan dari Unit Pentadbiran
                                    @endif
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