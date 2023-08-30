@extends('layouts.public.main_inner_pemohon')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <form class="form" action="{{ route('pemohon.permohonan_sijil_tahfiz.update', $permohonan->id)}}" method="post" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="card shadow-none">
                            <div class="card-header border-0">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-dark">MAKLUMAT PEMOHON (PERSONAL PARTICULARS)</span>
                                </h3>
                            </div>
                            <div id="kt_account_settings_profile_details" class="collapse show">
                                <div class="card-body border-top p-9">
                                    <div class="row mb-6">
                                        <div class="col-lg-4">
                                            {{ Form::label('name', 'Nama Penuh', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                            <div class="form-text mt-0">Full Name</div>
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                            {{ Form::text('name', $permohonan ? $permohonan->name : '',['class' => 'form-control form-control-lg '.($errors->has('name') ? 'is-invalid':'')]) }}
                                            <div class="form-text">Nama penuh mengikut K.P / Full name according to your IC</div>
                                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
            
                                    <div class="row mb-6">
                                        <div class="col-lg-4">
                                            {{ Form::label('ic_no', 'No. Kad Pengenalan / Pasport', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                            <div class="form-text mt-0">I/C Number / Passport</div>
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                            {{ Form::text('ic_no',$pemohon->username,['class' => 'form-control form-control-lg','disabled']) }}
                                        </div>
                                    </div>
            
                                    <div class="row mb-6">
                                        <div class="col-lg-4">
                                            {{ Form::label('dob', 'Tarikh Lahir', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                            <div class="form-text mt-0">Date of Birth</div>
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                            {{-- <input class="form-control form-control-lg "name="tarikh_lahir" id="tarikh_lahir" onkeydown="return false"/> --}}
                                            {{ Form::text('dob', $permohonan ? Carbon\Carbon::parse($permohonan->dob)->format('d/m/Y') : '',['class' => 'form-control form-control-lg '.($errors->has('dob') ? 'is-invalid':''), 'id' =>'tarikh_lahir','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            @error('dob') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
            
                                    <div class="row mb-6">
                                        <div class="col-lg-4">
                                            {{ Form::label('email', 'Alamat Emel', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                            <div class="form-text mt-0">Email Address</div>
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                            {{ Form::email('email',$pemohon->email,['class' => 'form-control form-control-lg', 'disabled']) }}
                                            {{-- <div class="form-text mt-0">Sila masukkan alamat emel yang sah untuk dihubungi / Please enter a valid email address to be contacted</div> --}}
                                        </div>
                                    </div>
            
                                    <div class="separator separator-dashed my-6"></div>
            
                                    <div class="row mb-6">
                                        <div col-lg-12>
                                            {{ Form::label('', 'Alamat Tetap', ['class' => 'col-form-label fw-semibold fs-6 pb-0 pt-0']) }}
                                        </div>
                                    </div>
            
                                    <div class="row mb-6">
                                        <div class="col-lg-4">
                                            {{ Form::label('address', 'Alamat', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                            <div class="form-text mt-0">Address</div>
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                            {{ Form::textarea('address',$permohonan ? $permohonan->address : '',['class' => 'form-control form-control-lg '.($errors->has('address') ? 'is-invalid':''), 'rows'=>'4']) }}
                                            @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
            
                                    <div class="row mb-6">
                                        <div class="col-lg-4">
                                            {{ Form::label('postcode', 'Poskod', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                            <div class="form-text mt-0">Postcode</div>
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                            {{ Form::number('postcode',$permohonan ? $permohonan->postcode : '',['class' => 'form-control form-control-lg '.($errors->has('postcode') ? 'is-invalid':'')]) }}
                                            @error('postcode') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
            
                                    <div class="row mb-6">
                                        <div class="col-lg-4">
                                            {{ Form::label('negeri_id', 'Negeri', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                            <div class="form-text mt-0">State</div>
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                            {{ Form::select('negeri_id', $negeri, $permohonan ? $permohonan->negeri_id : '', ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg '.($errors->has('negeri_id') ? 'is-invalid':'')]) }}
                                            @error('negeri_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
            
                                    <div class="separator separator-dashed my-6"></div>
            
            
                                    <div class="row mb-6">
                                        <div class="col-lg-4">
                                            {{ Form::label('phone_no', 'No. Telefon', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                            <div class="form-text mt-0">Phone Number</div>
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                            {{ Form::number('phone_no',$permohonan ? $permohonan->phone_no : '',['class' => 'form-control form-control-lg '.($errors->has('phone_no') ? 'is-invalid':'')]) }}
                                            @error('phone_no') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
            
                                    <div class="row mb-6">
                                        <div class="col-lg-4">
                                            {{ Form::label('gender', 'Jantina', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                            <div class="form-text mt-0">Gender</div>
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                            {{ Form::select('gender', ['L' => 'Lelaki (Male)', 'P' => 'Perempuan (Female)'], $permohonan ? $permohonan->gender : '', ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg '.($errors->has('gender') ? 'is-invalid':'')]) }}
                                            @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
            
                                    <div class="row mb-6" >
                                        <div class="col-lg-4">
                                            {{ Form::label('masalah_penglihatan', 'Masalah Penglihatan', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                            {{ Form::select('masalah_penglihatan', ['0' => 'Tidak', '1' => 'Ya'], $permohonan->masalah_penglihatan, ['placeholder' => 'Sila Pilih', 'data-control'=>'select2', 'class' =>'form-contorl-lg form-select '.($errors->has('masalah_penglihatan') ? 'is-invalid':''),'id'=>'masalah_penglihatan' ]) }}
                                            @error('masalah_penglihatan') <div class="invalid-feedback">{{ $message }}</div> @enderror  
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="card shadow-none mt-2">
                            <div class="card-header border-0">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-dark">PUSAT PEPERIKSAAN (EXAM CENTER)</span>
                                </h3>
                            </div>
                            <div id="kt_account_settings_profile_details" class="collapse show">
                                <div class="card-body border-top p-9">
                                    <div class="row mb-6">
                                        <div class="col-lg-4">
                                            {{ Form::label('siri_id', 'Siri Peperiksaan', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                            {{ Form::select('siri_id', $siri_peperiksaan, $permohonan->siri_id, ['placeholder' => 'Sila Pilih', 'data-control'=>'select2', 'class' =>'form-contorl-lg form-select '.($errors->has('siri_id') ? 'is-invalid':''),'id'=>'siri_id' ]) }}
                                            @error('siri_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
            
                                    <div class="row mb-6">
                                        <div class="col-lg-4">
                                            {{ Form::label('pusat_peperiksaan_id', 'Pusat Peperiksaan', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                            {{ Form::select('pusat_peperiksaan_id', $pusatPeperiksaans, $permohonan->pusat_peperiksaan_id, ['placeholder' => 'Sila Pilih','data-control'=>'select2', 'class' =>'form-contorl-lg form-select '.($errors->has('pusat_peperiksaan_id') ? 'is-invalid':''),'id'=>'pusat_peperiksaan_id' ]) }}
                                            @error('pusat_peperiksaan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
            
                                    <div class="row mb-6" id="ppnegeridiv">
                                        <div class="col-lg-4">
                                            {{ Form::label('pusat_peperiksaan_negeri_id', 'Negeri Pusat Peperiksaan', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                            {{ Form::select('pusat_peperiksaan_negeri_id', $pusatPeperiksaanNegeris, $permohonan->pusat_peperiksaan_negeri_id, ['placeholder' => 'Sila Pilih', 'data-control'=>'select2', 'class' =>'form-contorl-lg form-select '.($errors->has('pusat_peperiksaan_negeri_id') ? 'is-invalid':''),'id'=>'pusat_peperiksaan_negeri_id' ]) }}
                                            @error('pusat_peperiksaan_negeri_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="card shadow-none mt-2">
                            <div class="card-header border-0">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-dark">MAKLUMAT PUSAT TAHFIZ (TAHFIZ CENTER PARTICULARS)</span>
                                </h3>
                            </div>
                            <div id="kt_account_settings_profile_details" class="collapse show">
                                <div class="card-body border-top p-9">
                                    <div class="row mb-6" >
                                        <div class="col-lg-4">
                                            {{ Form::label('nama_tahfiz', 'Nama Pusat Tahfiz', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                                {{ Form::text('nama_tahfiz',$permohonan->nama_tahfiz,['class' => 'form-control form-control-lg '.($errors->has('nama_tahfiz') ? 'is-invalid':''), 'id' =>'nama_tahfiz','autocomplete' => 'off']) }}
                                                @error('nama_tahfiz') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-6" >
                                        <div class="col-lg-4">
                                            {{ Form::label('alamat_tahfiz', 'Alamat Pusat Tahfiz', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                                <textarea name="alamat_tahfiz" class="form-control" id="kt_docs_maxlength_textarea" placeholder="" rows="3">{{ $permohonan->alamat_tahfiz }}</textarea>
                                                @error('alamat_tahfiz') <div class="invalid-feedback">{{ $message }}</div> @enderror
            
                                        </div>
                                    </div>
                                    <div class="row mb-6" >
                                        <div class="col-lg-4">
                                            {{ Form::label('poskod_tahfiz', 'Poskod', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                                {{ Form::text('poskod_tahfiz',$permohonan->poskod_tahfiz,['class' => 'form-control form-control-lg '.($errors->has('poskod_tahfiz') ? 'is-invalid':''), 'id' =>'poskod_tahfiz','autocomplete' => 'off']) }}
                                                @error('poskod_tahfiz') <div class="invalid-feedback">{{ $message }}</div> @enderror
            
                                        </div>
                                    </div>
                                    <div class="row mb-6" >
                                        <div class="col-lg-4">
                                            {{ Form::label('negeri_tahfiz', 'Negeri', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                                {{ Form::select('negeri_tahfiz', $negeri, $permohonan->negeri_tahfiz, ['placeholder' => 'Sila Pilih', 'data-control'=>'select2', 'class' =>'form-contorl-lg form-select '.($errors->has('negeri_tahfiz') ? 'is-invalid':''),'id'=>'negeri_tahfiz' ]) }}
                                                @error('negeri_tahfiz') <div class="invalid-feedback">{{ $message }}</div> @enderror  
            
                                        </div>
                                    </div>
                                    <div class="row mb-6" >
                                        <div class="col-lg-4">
                                            {{ Form::label('jenis_pengajian', 'Jenis Pengajian', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                                {{ Form::select('jenis_pengajian', ['1' => 'Kerajaan', '2' => 'Swasta'], $permohonan->jenis_pengajian, ['placeholder' => 'Sila Pilih', 'data-control'=>'select2', 'class' =>'form-contorl-lg form-select '.($errors->has('jenis_pengajian') ? 'is-invalid':''),'id'=>'jenis_pengajian' ]) }}
                                                @error('jenis_pengajian') <div class="invalid-feedback">{{ $message }}</div> @enderror  
            
                                        </div>
                                    </div>
                                    <div class="row mb-6" >
                                        <div class="col-lg-4">
                                            {{ Form::label('tahun_mula', 'Tahun Mula Pengajian', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                                {{ Form::text('tahun_mula',$permohonan->tahun_mula,['class' => 'form-control form-control-lg '.($errors->has('tahun_mula') ? 'is-invalid':''), 'id' =>'tahun_mula','autocomplete' => 'off']) }}
                                                @error('tahun_mula') <div class="invalid-feedback">{{ $message }}</div> @enderror
            
                                        </div>
                                    </div>
                                    <div class="row mb-6" >
                                        <div class="col-lg-4">
                                            {{ Form::label('tahun_tamat', 'Tahun Tamat Pengajian', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                                {{ Form::text('tahun_tamat',$permohonan->tahun_tamat,['class' => 'form-control form-control-lg '.($errors->has('tahun_tamat') ? 'is-invalid':''), 'id' =>'tahun_tamat','autocomplete' => 'off']) }}
                                                @error('tahun_tamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
            
                                        </div>
                                    </div>
                                    <div class="row mb-6" >
                                        <div class="col-lg-4">
                                            {{ Form::label('tahap_pencapaian_hafazan', 'Tahap Pencapaian Hafazan(Juzuk)', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                                {{ Form::text('tahap_pencapaian_hafazan',$permohonan->tahap_pencapaian_hafazan,['class' => 'form-control form-control-lg '.($errors->has('tahap_pencapaian_hafazan') ? 'is-invalid':''), 'id' =>'tahap_pencapaian_hafazan','autocomplete' => 'off']) }}
                                                @error('tahap_pencapaian_hafazan') <div class="invalid-feedback">{{ $message }}</div> @enderror
            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                        <div class="card shadow-none mt-2">
                            <div class="card-header border-0">
                                <h3 class="card-title align-items-start flex-column">
                                    <span class="card-label fw-bold text-dark">MUAT NAIK DOKUMEN (UPLOAD DOCUMENT)</span>
                                </h3>
                            </div>
                            <div id="kt_account_settings_profile_details" class="collapse show">
                                <div class="card-body border-top p-9">
                                    <div class="row mb-6" >
                                        <div class="col-lg-4">
                                            {{ Form::label('current_file', 'Dokumen Yang Dihantar', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                                        </div>
                                        <div class="col-lg-8 fv-row">
                                            <ul>
                                                @foreach ($permohonan->permohonanSijilTahfizFile as $dokumen)
                                                    <li>{{ strtoupper($dokumen->document_type).' :' }}<a href="{{ asset($dokumen->file_upload_path) }}">{{ $dokumen->file_upload_name }}</a></li>
                                                @endforeach
                                                </ul>
                                        </div>
                                    </div>
                                </div>
                                <div id="kt_account_settings_profile_details" class="collapse show">
                                    <div class="card-body border-top p-9">
                                        <div class="row mb-6" >
                                            <div class="col-lg-4">
                                                {{ Form::label('mykad', 'MyKad', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                            </div>
                                            <div class="col-lg-8 fv-row">
                                                <div class="w-100">
                                                    <input type="file" name="mykad" class="{{ 'form-control form-control-lg '.($errors->has('mykad') ? 'is-invalid':'') }}">
                                                    @error('mykad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mb-6" >
                                            <div class="col-lg-4">
                                                {{ Form::label('dokumen_sokongan', 'Dokumen Sokongan', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                            </div>
                                            <div class="col-lg-8 fv-row">
                                                <div class="w-100">
                                                    <input type="file" name="dokumen_sokongan" class="{{ 'form-control form-control-lg '.($errors->has('dokumen_sokongan') ? 'is-invalid':'') }}">
                                                    <span class="fs-8 text-muted">Sijil Tamat Hafazan 30 Juzuk / Surat Pengesahan Hafazan 30 juzuk / Rekod Hafazan 30 Juzuk yang disahkan oleh pegawai kerajaan</span>
                                                    @error('mykad') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow-none mt-2">
                            <div class="card-body border-top p-9">
                                <div class="row">
                                    <div class="col-lg-8 fv-row offset-md-9">
                                        <div class="d-flex">
                                            <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-primary btn-lg me-3">
                                                <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                            </button>
                                            <a href="{{ route('pemohon.permohonan_sijil_tahfiz.index') }}" class="btn btn-light btn-lg">Batal</a>
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
$(document).ready(function () {
    $('#ppnegeridiv').show();

    $("#siri_id").on('change', function(){
        var siri_id = this.value;

        $("#pusat_peperiksaan_id").val('');
        $("#pusat_peperiksaan_negeri_id").val('');
        $('#ppnegeridiv').hide();
        $("#pusat_peperiksaan_id").select2({
            ajax: {
                url: "{{route('pemohon.permohonan_sijil_tahfiz.fetchPusatPeperiksaan')}}",
                type: "GET",
                data: {
                            siri_id: siri_id,
                            _token: '{{csrf_token()}}'
                        },
                dataType: 'json',
                processResults: function (data) {

                    data.forEach(function(item) {
                        if(item.text.includes("Penuh"))
                        {
                            item.disabled = true;
                        }
                    });
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data
                    };
                },
            }
        })
    })

    $("#pusat_peperiksaan_id").on('change', function(){
        $('#ppnegeridiv').show();
        var pp_id = this.value;

        $("#pusat_peperiksaan_negeri_id").val('');
        $("#pusat_peperiksaan_negeri_id").select2({
            ajax: {
                url: "{{route('pemohon.permohonan_sijil_tahfiz.fetchPusatPeperiksaan.negeri')}}",
                type: "GET",
                data: {
                            pusat_peperiksaan_id: pp_id,
                            _token: '{{csrf_token()}}'
                        },
                dataType: 'json',
                processResults: function (data) {
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: data
                };
                }
            }
        })
    })
});
</script>

@endpush
