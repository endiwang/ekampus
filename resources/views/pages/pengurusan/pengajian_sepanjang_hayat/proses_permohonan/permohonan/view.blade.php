@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <form class="form" action="{{ route('pelajar.permohonan.sijil_tahfiz.update', $permohonan->id)}}" method="post" enctype="multipart/form-data">
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
                                            {{ Form::text('',$pelajar->ni_ic,['class' => 'form-control form-control-sm ', 'id' =>'nama_tahfiz','autocomplete' => 'off', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                </div><div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('dob', 'Tarikh Lahir', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('',date('d/m/Y',strtotime($pelajar->tarikh_lahir)),['class' => 'form-control form-control-sm ', 'id' =>'nama_tahfiz','autocomplete' => 'off', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                </div><div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('umur', 'Umur', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            @php
                                                $today = date('d/m/Y');
                                                $age = \Carbon\Carbon::parse($pelajar->tarikh_lahir)->age;
                                            @endphp
                                            {{ Form::text('',$age,['class' => 'form-control form-control-sm ', 'id' =>'nama_tahfiz','autocomplete' => 'off', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                </div><div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('alamat', 'Alamat Pemohon', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <textarea class="form-control" id="kt_docs_maxlength_textarea" placeholder="" rows="3" disabled>{{ $pelajar->alamat }}</textarea>
                                        </div>
                                    </div>
                                </div><div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('poskod', 'Poskod', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('',$pelajar->poskod,['class' => 'form-control form-control-sm ', 'id' =>'nama_tahfiz','autocomplete' => 'off', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                </div><div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('name', 'Negeri', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('',$pelajar->negeri->nama ?? '',['class' => 'form-control form-control-sm ', 'id' =>'nama_tahfiz','autocomplete' => 'off', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('jantina', 'Jantina', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            @php
                                                if($pelajar->jantina == "L"){
                                                    $jantina = 'Lelaki';
                                                } else {
                                                    $jantina = 'Perempuan';
                                                }
                                            @endphp
                                            {{ Form::text('',$jantina,['class' => 'form-control form-control-sm ', 'id' =>'nama_tahfiz','autocomplete' => 'off', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('telefon', 'No Telefon', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('',$pelajar->no_tel,['class' => 'form-control form-control-sm ', 'id' =>'nama_tahfiz','autocomplete' => 'off', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('email', 'Email', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('',$pelajar->email,['class' => 'form-control form-control-sm ', 'id' =>'nama_tahfiz','autocomplete' => 'off', 'disabled'=>true]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('masalah_penglihatan', 'Masalah Penglihatan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('masalah_penglihatan', ['0' => 'Tidak', '1' => 'Ya'], $permohonan->masalah_penglihatan, ['placeholder' => 'Sila Pilih', 'data-control'=>'select2', 'class' =>'form-contorl form-select form-select-sm '.($errors->has('masalah_penglihatan') ? 'is-invalid':''),'id'=>'masalah_penglihatan', 'disabled'=>true ]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <div class="card-body py-5">
                                <h3>Pusat Peperiksaan</h3>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('siri_id', 'Siri Peperiksaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('siri_id', $siri_peperiksaan, $permohonan->siri_id, ['placeholder' => 'Sila Pilih', 'data-control'=>'select2', 'class' =>'form-contorl form-select form-select-sm '.($errors->has('siri_id') ? 'is-invalid':''),'id'=>'siri_id', 'disabled'=>true ]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('pusat_peperiksaan_id', 'Pusat Peperiksaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('pusat_peperiksaan_id', $pusatPeperiksaans, $permohonan->pusat_peperiksaan_id, ['placeholder' => 'Sila Pilih', 'data-control'=>'select2', 'class' =>'form-contorl form-select form-select-sm '.($errors->has('pusat_peperiksaan_id') ? 'is-invalid':''),'id'=>'pusat_peperiksaan_id', 'disabled'=>true ]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" id="ppnegeridiv">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('pusat_peperiksaan_negeri_id', 'Negeri Pusat Peperiksaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('pusat_peperiksaan_negeri_id', $pusatPeperiksaanNegeris, $permohonan->pusat_peperiksaan_negeri_id, ['placeholder' => 'Sila Pilih', 'data-control'=>'select2', 'class' =>'form-contorl form-select form-select-sm '.($errors->has('pusat_peperiksaan_negeri_id') ? 'is-invalid':''),'id'=>'pusat_peperiksaan_negeri_id', 'disabled'=>true ]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <div class="card-body py-5">
                                <h3>Maklumat Pengajian Tahfiz</h3>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('nama_tahfiz', 'Nama Pusat Tahfiz', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('nama_tahfiz',$permohonan->nama_tahfiz,['class' => 'form-control form-control-sm '.($errors->has('nama_tahfiz') ? 'is-invalid':''), 'id' =>'nama_tahfiz','autocomplete' => 'off', 'disabled'=>true]) }}
                                            @error('nama_tahfiz') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('alamat_tahfiz', 'Alamat Pusat Tahfiz', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <textarea name="alamat_tahfiz" class="form-control" id="kt_docs_maxlength_textarea" placeholder="" rows="3" disabled>{{ $permohonan->alamat_tahfiz }}</textarea>
                                            @error('alamat_tahfiz') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('poskod_tahfiz', 'Poskod', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('poskod_tahfiz',$permohonan->poskod_tahfiz,['class' => 'form-control form-control-sm '.($errors->has('poskod_tahfiz') ? 'is-invalid':''), 'id' =>'poskod_tahfiz','autocomplete' => 'off', 'disabled'=>true]) }}
                                            @error('poskod_tahfiz') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('negeri_tahfiz', 'Negeri', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('negeri_tahfiz', $negeriSelection, $permohonan->negeri_tahfiz, ['placeholder' => 'Sila Pilih', 'data-control'=>'select2', 'class' =>'form-contorl form-select form-select-sm '.($errors->has('negeri_tahfiz') ? 'is-invalid':''),'id'=>'negeri_tahfiz', 'disabled'=>true]) }}
                                            @error('negeri_tahfiz') <div class="invalid-feedback">{{ $message }}</div> @enderror  
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('jenis_pengajian', 'Jenis Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('jenis_pengajian', ['1' => 'Kerajaan', '2' => 'Swasta'], $permohonan->jenis_pengajian, ['placeholder' => 'Sila Pilih', 'data-control'=>'select2', 'class' =>'form-contorl form-select form-select-sm '.($errors->has('jenis_pengajian') ? 'is-invalid':''),'id'=>'jenis_pengajian', 'disabled'=>true]) }}
                                            @error('jenis_pengajian') <div class="invalid-feedback">{{ $message }}</div> @enderror  
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tahun_mula', 'Tahun Mula Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('tahun_mula',$permohonan->tahun_mula,['class' => 'form-control form-control-sm '.($errors->has('tahun_mula') ? 'is-invalid':''), 'id' =>'tahun_mula','autocomplete' => 'off', 'disabled'=>true]) }}
                                            @error('tahun_mula') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tahun_tamat', 'Tahun Tamat Pengajian', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('tahun_tamat',$permohonan->tahun_tamat,['class' => 'form-control form-control-sm '.($errors->has('tahun_tamat') ? 'is-invalid':''), 'id' =>'tahun_tamat','autocomplete' => 'off', 'disabled'=>true]) }}
                                            @error('tahun_tamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tahap_pencapaian_hafazan', 'Tahap Pencapaian Hafazan(Juzuk)', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('tahap_pencapaian_hafazan',$permohonan->tahap_pencapaian_hafazan,['class' => 'form-control form-control-sm '.($errors->has('tahap_pencapaian_hafazan') ? 'is-invalid':''), 'id' =>'tahap_pencapaian_hafazan','autocomplete' => 'off', 'disabled'=>true]) }}
                                            @error('tahap_pencapaian_hafazan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <div class="card-body py-5">
                                <h3>Muat Naik Dokumen</h3>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('current_file', 'Dokumen Yang Dihantar', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <ul>
                                            @foreach ($permohonan->permohonanSijilTahfizFile as $dokumen)
                                                <li><a href="{{ asset($dokumen->file_upload_path) }}">{{ $dokumen->document_type }}</li>
                                            @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <h3>Status Kelayakan</h3>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('status', 'Status Kelayakan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                {{ Form::checkbox('status', 1, ($permohonan->status == 1 ? true:false), ['class' => 'form-check-input h-25px w-60px mt-1', 'disabled'=>true]); }}
                                                <span class="form-check-label fs-7 fw-semibold mt-2">
                                                    Layak
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
                                            {{-- <input type="hidden" name="pelajar_id" value="{{ $pelajar->id }}"> --}}
                                            <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                            </button>
                                            <a href="{{ route('pengurusan.pengajian_sepanjang_hayat.proses_permohonan.permohonan.index') }}" class="btn btn-light btn-sm">Batal</a>
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
