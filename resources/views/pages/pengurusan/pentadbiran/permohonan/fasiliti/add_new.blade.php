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
                        <form class="form" action="{{url('pengurusan/pentadbiran/fasiliti/update')}}" method="post" enctype="multipart/form-data">
                        
                    @else
                        <form class="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                        
                        
                    @endif
                            @csrf
                            @if($model->id) @method('POST') <input type="hidden" name="id" value="{{data_get($model,'id')}}" /> @endif
                            
                            @if($user->is_student == 1)
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('dokumen', 'Muat Naik Surat Kelulusan HEP', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="file" class="form-control form-control-sm" name="file"  accept=".pdf">
                                        @error('dokumen') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            @endif


                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kategori', 'Kategori', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        @if($user->is_student == 1)
                                        {{ Form::select('kategori', $selFasilitiPelajar, $model->fasiliti_id, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('kategori') ? 'is-invalid':'') ]) }}
                                        @elseif($user->is_staff == 1)
                                        {{ Form::select('kategori', $selFasilitiAll, $model->fasiliti_id, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('kategori') ? 'is-invalid':'') ]) }}
                                        @else
                                        {{ Form::select('kategori', $selFasilitiAll, $model->fasiliti_id, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('kategori') ? 'is-invalid':'') ]) }}
                                        @endif
                                        
                                        @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh', 'Tarikh Penggunaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::date('tarikh', $model->tarikh_penggunaan ?? '' ,['class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('tarikh') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            @if(!$user->is_student)
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('makan_minum', 'Makan /Minum', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                    {{ Form::select('makan_minum', $jenisMakan, $model->makan_minum, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('kategori') ? 'is-invalid':'') ]) }}
                                        @error('makan_minum') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('peserta', 'Peserta', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                    {{ Form::select('peserta', $peserta, $model->peserta, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('kategori') ? 'is-invalid':'') ]) }}
                                        @error('peserta') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jumlah_peserta', 'Jumlah Peserta', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::number('jumlah_peserta', $model->jumlah_peserta ?? '' ,['class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('jumlah_peserta') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('peralatan_id', 'Peralatan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        @foreach($selPeralatan as $a => $b )
                                            <label><input type="checkbox" name="peralatan[]" value="{{ $a }}"> {{ $b }}</label><br/>
                                        @endforeach
                                        
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('catatan_tambahan', 'Catatan Tambahan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('catatan_tambahan', $model->catatan_tambahan ?? '' ,['class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('catatan_tambahan') <div class="invalid-feedback">{{ $message }}</div> @enderror
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