@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <form class="form" action="{{ route('pengurusan.pengajian_sepanjang_hayat.pemarkahan.pengesahan_markah_sijil_tahfiz.update', $id)}}" method="post">
                        @method('PATCH')
                        @csrf
                        <div class="card">
                            <div class="card-body py-5">
                                <h3>Maklumat Pemohon</h3>
                                <div class="row fv-row mb-2" >
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
                            </div>
                        </div>

                        <div class="card mt-2">
                            <div class="card-body py-5">
                                <h3>Ruangan Pemarkahan</h3>
                                <h5>Al-Quran</h5>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('al_quran_syafawi', 'Al-Quran Syafawi', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group w-100">
                                            {{ Form::text('', $pemarkahan->al_quran_syafawi,['class' => 'form-control form-control-sm ', 'id' =>'al_quran_syafawi','autocomplete' => 'off', 'aria-describedby'=>'basic-addon2', 'disabled'=>true]) }}
                                            <span class="input-group-text" id="basic-addon2">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('al_quran_tahriri', 'Al-Quran Tahriri', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group w-100">
                                            {{ Form::text('', $pemarkahan->al_quran_tahriri,['class' => 'form-control form-control-sm ', 'id' =>'al_quran_tahriri','autocomplete' => 'off', 'aria-describedby'=>'basic-addon3', 'disabled'=>true]) }}
                                            <span class="input-group-text" id="basic-addon3">%</span>
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
                                            {{ Form::text('', $pemarkahan->tajwid,['class' => 'form-control form-control-sm ', 'id' =>'tajwid','autocomplete' => 'off', 'aria-describedby'=>'basic-addon4', 'disabled'=>true]) }}
                                            <span class="input-group-text" id="basic-addon4">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('fiqh_ibadah', 'Fiqh Ibadah', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group w-100">
                                            {{ Form::text('', $pemarkahan->fiqh_ibadah,['class' => 'form-control form-control-sm ', 'id' =>'fiqh_ibadah','autocomplete' => 'off', 'aria-describedby'=>'basic-addon5', 'disabled'=>true]) }}
                                            <span class="input-group-text" id="basic-addon5">%</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('akidah', 'Akidah', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group w-100">
                                            {{ Form::text('', $pemarkahan->akidah,['class' => 'form-control form-control-sm ', 'id' =>'akidah','autocomplete' => 'off', 'aria-describedby'=>'basic-addon6', 'disabled'=>true]) }}
                                            <span class="input-group-text" id="basic-addon6">%</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mt-2">
                            <div class="card-body py-5">
                                <h3>Gred & Markah</h3>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('total_mark', 'Markah Keseluruhan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group w-100">
                                            {{ Form::text('', $pemarkahan->total_mark,['class' => 'form-control form-control-sm ', 'id' =>'tajwid','autocomplete' => 'off', 'aria-describedby'=>'basic-addon4', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('status_lulus', 'Status Lulus', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group w-100">
                                            @php
                                                if($pemarkahan->status_kelulusan){
                                                    $status_lulus = 'Lulus';
                                                } else {
                                                    $status_lulus = 'Gagal';
                                                }
                                            @endphp
                                            {{ Form::text('', $status_lulus,['class' => 'form-control form-control-sm ', 'id' =>'fiqh_ibadah','autocomplete' => 'off', 'aria-describedby'=>'basic-addon5', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('taraf_pencapaian', 'Taraf Pencapaian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="input-group w-100">
                                            {{ Form::text('', $pemarkahan->keputusan_peperiksaan,['class' => 'form-control form-control-sm ', 'id' =>'akidah','autocomplete' => 'off', 'aria-describedby'=>'basic-addon6', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                </div>
                                <h3>Pengesahan</h3>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('approval', 'Pengesahan Markah Calon', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                {{ Form::checkbox('approval', 1, ($pemarkahan->approval == 0 ? 0:1), ['class' => 'form-check-input h-25px w-60px mt-1', 'disabled'=>true]); }}
                                                <span class="form-check-label fs-7 fw-semibold mt-2">
                                                    Ya
                                                </span>
                                            </label>
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
                                            <a href="{{ route('pengurusan.pengajian_sepanjang_hayat.pemarkahan.pengesahan_markah_sijil_tahfiz.index') }}" class="btn btn-light btn-sm">Kembali</a>
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
