@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <form class="form" action="{{ route('pengurusan.pengajian_sepanjang_hayat.pemarkahan.calon_peperiksaan_sijil_tahfiz.update', $id)}}" method="post">
                        @method('PATCH')
                        @csrf
                        <div class="card">
                            <div class="card-body py-5">
                                <h3>Maklumat Pemohon</h3>
                                <div class="row fv-row mb-2" >
                                    <input type="hidden" name="pelajar_id" value="{{ $pelajar->id }}">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('name', 'Nama Pemohon', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('',$pelajar->nama,['class' => 'form-control form-control-sm ', 'id' =>'nama_tahfiz','autocomplete' => 'off', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('mykad', 'MyKad', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('',$pelajar->no_ic,['class' => 'form-control form-control-sm ', 'id' =>'nama_tahfiz','autocomplete' => 'off', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('no_tel', 'No Telefon', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('',$pelajar->no_tel,['class' => 'form-control form-control-sm ', 'id' =>'nama_tahfiz','autocomplete' => 'off', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('nama_pusat_tahfiz', 'Pusat Tahfiz', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('',$permohonan->nama_tahfiz,['class' => 'form-control form-control-sm ', 'id' =>'nama_tahfiz','autocomplete' => 'off', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-2">
                            <div class="card-body py-5">
                                <h3>Ruangan Pemarkahan</h3>
                                <h5>Al-Quran</h5>
                                @if ($syafawi)
                                <input type="hidden" name="syafawi" value='{{ $syafawi }}'>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('al_quran_syafawi', 'Al-Quran Syafawi', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group w-100">
                                            {{ Form::text('al_quran_syafawi', '',['class' => 'form-control form-control-sm '.($errors->has('al_quran_syafawi') ? 'is-invalid':''), 'id' =>'al_quran_syafawi','autocomplete' => 'off', 'aria-describedby'=>'basic-addon2']) }}
                                            <span class="input-group-text" id="basic-addon2">%</span>
                                            @error('al_quran_syafawi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('al_quran_tahriri', 'Al-Quran Tahriri', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group w-100">
                                            {{ Form::text('al_quran_tahriri', '',['class' => 'form-control form-control-sm '.($errors->has('al_quran_tahriri') ? 'is-invalid':''), 'id' =>'al_quran_tahriri','autocomplete' => 'off', 'aria-describedby'=>'basic-addon3']) }}
                                            <span class="input-group-text" id="basic-addon3">%</span>
                                            @error('al_quran_tahriri') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <h5>Pengetahuan Islam</h5>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tajwid', 'Tajwid', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group w-100">
                                            {{ Form::text('tajwid', '',['class' => 'form-control form-control-sm '.($errors->has('tajwid') ? 'is-invalid':''), 'id' =>'tajwid','autocomplete' => 'off', 'aria-describedby'=>'basic-addon4']) }}
                                            <span class="input-group-text" id="basic-addon4">%</span>
                                            @error('tajwid') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('fiqh_ibadah', 'Fiqh Ibadah', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group w-100">
                                            {{ Form::text('fiqh_ibadah', '',['class' => 'form-control form-control-sm '.($errors->has('fiqh_ibadah') ? 'is-invalid':''), 'id' =>'fiqh_ibadah','autocomplete' => 'off', 'aria-describedby'=>'basic-addon5']) }}
                                            <span class="input-group-text" id="basic-addon5">%</span>
                                            @error('fiqh_ibadah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('akidah', 'Akidah', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group w-100">
                                            {{ Form::text('akidah', '',['class' => 'form-control form-control-sm '.($errors->has('akidah') ? 'is-invalid':''), 'id' =>'akidah','autocomplete' => 'off', 'aria-describedby'=>'basic-addon6']) }}
                                            <span class="input-group-text" id="basic-addon6">%</span>
                                            @error('akidah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                @endif
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
