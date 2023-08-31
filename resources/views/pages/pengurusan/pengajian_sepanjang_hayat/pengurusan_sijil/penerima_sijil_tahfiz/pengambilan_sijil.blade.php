@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <form class="form" action="{{ route('pengurusan.pengajian_sepanjang_hayat.pengurusan_sijil_tahfiz.penerima_sijil_tahfiz.pengambilan_sijil.store', $id)}}" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-body py-5">
                                <h3>Maklumat Calon</h3>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('name', 'Nama Calon', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('',$pemarkahan->permohonanSijilTahfiz->name,['class' => 'form-control form-control-sm ', 'id' =>'nama_tahfiz','autocomplete' => 'off', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('mykad', 'MyKad', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('',$pemarkahan->pemohon->username,['class' => 'form-control form-control-sm ', 'id' =>'nama_tahfiz','autocomplete' => 'off', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-2">
                            <div class="card-body py-5">
                                <h3>Maklumat Pengambilan Sijil</h3>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('no_sijil', 'No Sijil', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group w-100">
                                            {{ Form::text('no_sijil', '',['class' => 'form-control form-control-sm '.($errors->has('al_quran_syafawi') ? 'is-invalid':''), 'id' =>'no_sijil','autocomplete' => 'off', 'aria-describedby'=>'basic-addon2', 'required' => 'required']) }}
                                            @error('no_sijil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tarikh_ambil_sijil', 'Tarikh Ambil Sijil', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group w-100">
                                            {{ Form::date('tarikh_ambil_sijil', @$bayaran->date, ['class' => 'form-control form-control-sm ' . ($errors->has('tarikh_ambil_sijil') ? 'is-invalid':''), 'id' => 'tarikh_ambil_sijil', 'onkeydown' => 'return true', 'autocomplete' => 'off', 'required' => 'required']) }}
                                            @error('tarikh_ambil_sijil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('nama_pengambil_sijil', 'Nama Pengambil Sijil', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group w-100">
                                            {{ Form::text('nama_pengambil_sijil', '',['class' => 'form-control form-control-sm '.($errors->has('nama_pengambil_sijil') ? 'is-invalid':''), 'id' =>'tajwid','autocomplete' => 'off', 'aria-describedby'=>'basic-addon4', 'required' => 'required']) }}
                                            @error('nama_pengambil_sijil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card mt-2">
                            <div class="card-body py-5">
                                
                                <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                        <div class="d-flex">
                                            <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                            </button>
                                            <a href="{{ route('pengurusan.pengajian_sepanjang_hayat.pemarkahan.calon_peperiksaan_sijil_tahfiz.index') }}" class="btn btn-light btn-sm">Batal</a>
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
<script>

</script>

@endpush
