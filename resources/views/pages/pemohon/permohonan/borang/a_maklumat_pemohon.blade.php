<div class="card shadow-none" id="formPermohonanA">
    <div class="card-header border-0">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-dark">MAKLUMAT PEMOHON (PERSONAL PARTICULARS)</span>
        </h3>
    </div>
    <div id="kt_account_settings_profile_details" class="collapse show">
        <div class="card-body border-top p-9">
            <input type="hidden" name="kursus_id" value="{{ $kursus->id }}">

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('avatars', 'Gambar', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Picture</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{-- <div class="image-input image-input-outline image-input-empty" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
                        <!--begin::Preview existing avatar-->
                        <div class="image-input-wrapper w-125px h-125px"></div>
                        <!--end::Preview existing avatar-->

                        <!--begin::Label-->
                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Tukar gambar">
                            <i class="bi bi-pencil-fill fs-7"></i>

                            <!--begin::Inputs-->
                            <input type="file" name="avatar" id="avatar" accept=".png, .jpg, .jpeg" />
                            <input type="hidden" name="avatar_remove" />
                            <!--end::Inputs-->
                        </label>
                        <!--end::Label-->

                        <!--begin::Cancel-->
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Tukar gambar">
                            <i class="bi bi-x fs-2"></i>
                        </span>
                        <!--end::Cancel-->

                        <!--begin::Remove-->
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Tukar gambar">
                            <i class="bi bi-x fs-2"></i>
                        </span>
                        <!--end::Remove-->
                    </div> --}}
                    <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
                        <!--begin::Preview existing avatar-->
                        <div class="image-input-wrapper w-125px h-125px" style="background-image: url('{{ asset($maklumat_pemohon->gambar)}}')"></div>
                        <!--end::Preview existing avatar-->
                        <!--begin::Label-->
                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                            <i class="bi bi-pencil-fill fs-7"></i>
                            <!--begin::Inputs-->
                            <input type="file" name="avatar" accept=".png, .jpg, .jpeg" value="{{ asset($maklumat_pemohon->gambar)}}"/>
                            <input type="hidden" name="avatar_remove" />
                            <!--end::Inputs-->
                        </label>
                        <!--end::Label-->
                        <!--begin::Cancel-->
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                            <i class="bi bi-x fs-2"></i>
                        </span>
                        <!--end::Cancel-->
                        <!--begin::Remove-->
                        <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                            <i class="bi bi-x fs-2"></i>
                        </span>
                        <!--end::Remove-->
                    </div>
                    <div class="form-text">Format gambar yang dibenarkan / Allowed picture format: png, jpg, jpeg.</div>
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('nama_pemohon', 'Nama Penuh', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Full Name</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::text('nama_pemohon',$maklumat_pemohon ? $maklumat_pemohon->nama_pemohon : '',['class' => 'form-control form-control-lg ']) }}
                    <div class="form-text">Nama penuh mengikut K.P / Full name according to your IC</div>
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('nama_jawi', 'Nama Jawi', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Jawi Name</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::text('nama_jawi',$maklumat_pemohon ? $maklumat_pemohon->nama_jawi : '',['class' => 'form-control form-control-lg ']) }}
                    <a href="https://www.arabic-keyboard.org/" target="blank">www.arabic-keyboard.org </a>
                    <div class="form-text mt-0">Sila salin "Copy" dan "Paste" semula di dalam ruangan NAMA JAWI. </div>
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('no_kp', 'No. Kad Pengenalan / Pasport', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">I/C Number / Passport</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::text('no_kp',$pemohon->username,['class' => 'form-control form-control-lg','disabled']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('tarikh_lahir', 'Tarikh Lahir', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Date of Birth</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{-- <input class="form-control form-control-lg "name="tarikh_lahir" id="tarikh_lahir" onkeydown="return false"/> --}}
                    {{ Form::text('tarikh_lahir', $maklumat_pemohon ? Carbon\Carbon::parse($maklumat_pemohon->tarikh_lahir)->format('d/m/Y') : '',['class' => 'form-control form-control-sm '.($errors->has('tarikh_lahir') ? 'is-invalid':''), 'id' =>'tarikh_lahir','onkeydown' =>'return false','autocomplete' => 'off']) }}
                    {{-- {{ Form::date('tarikh_lahir','',['class' => 'form-control form-control-lg ']) }} --}}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('alamat_emel', 'Alamat Emel', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Email Address</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::email('alamat_emel',$pemohon->email,['class' => 'form-control form-control-lg', 'disabled']) }}
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
                    {{ Form::label('alamat_tetap', 'Alamat Penuh', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Full Address</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::textarea('alamat_tetap',$maklumat_pemohon ? $maklumat_pemohon->alamat_tetap : '',['class' => 'form-control form-control-lg ', 'rows'=>'4']) }}
                    <div class="form-text mt-0">Sila masukkan alamat tetap mengikut kad pengenalan / Please your enter fixed address according to the identification card</div>

                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('bandar_tetap', 'Bandar', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">City</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::text('bandar_tetap',$maklumat_pemohon ? $maklumat_pemohon->bandar_tetap : '',['class' => 'form-control form-control-lg ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('poskod_tetap', 'Poskod', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Postcode</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::number('poskod_tetap',$maklumat_pemohon ? $maklumat_pemohon->poskod_tetap : '',['class' => 'form-control form-control-lg ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('negeri_tetap', 'Negeri', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">State</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('negeri_tetap', $negeri, $maklumat_pemohon ? $maklumat_pemohon->negeri_tetap : '', ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg ']) }}
                </div>
            </div>

            <div class="separator separator-dashed my-6"></div>

            <div class="row mb-6">
                <div col-lg-12>
                    {{ Form::label('', 'Alamat Surat-menyurat', ['class' => 'col-form-label fw-semibold fs-6 pb-0 pt-0']) }}
                    <button class="btn btn-sm btn-primary me-3" type="button" id="salin_alamat_tetap">Salin Alamat Tetap</button>
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('alamat_surat', 'Alamat Penuh', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Full Address</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::textarea('alamat_surat',$maklumat_pemohon ? $maklumat_pemohon->alamat_surat : '',['class' => 'form-control form-control-lg ', 'rows'=>'4']) }}
                    <div class="form-text mt-0">Sila masukkan alamat tetap mengikut kad pengenalan / Please your enter fixed address according to the identification card</div>

                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('bandar_surat', 'Bandar', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">City</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::text('bandar_surat',$maklumat_pemohon ? $maklumat_pemohon->bandar_surat : '',['class' => 'form-control form-control-lg ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('poskod_surat', 'Poskod', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Postcode</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::number('poskod_surat',$maklumat_pemohon ? $maklumat_pemohon->negeri_surat : '',['class' => 'form-control form-control-lg ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('negeri_surat', 'Negeri', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">State</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('negeri_surat', $negeri, $maklumat_pemohon ? $maklumat_pemohon->negeri_surat : '', ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg ']) }}
                </div>
            </div>

            <div class="separator separator-dashed my-6"></div>


            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('no_telefon', 'No. Telefon', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Phone Number</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::number('no_telefon',$maklumat_pemohon ? $maklumat_pemohon->no_telefon : '',['class' => 'form-control form-control-lg ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('jantina', 'Jantina', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Gender</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('jantina', ['L' => 'Lelaki (Male)', 'P' => 'Perempuan (Female)'], $maklumat_pemohon ? $maklumat_pemohon->jantina : '', ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg ']) }}
                </div>
            </div>



            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('negeri_kelahiran', 'Negeri Kelahiran', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">State of Birth</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('negeri_kelahiran', $negeri, $maklumat_pemohon ? $maklumat_pemohon->negeri_kelahiran : '', ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('keturunan', 'Keturunan', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Race</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('keturunan', ['M' => 'Melayu', 'C' => 'Cina', 'I' =>'India', 'OS' => 'Orang Asli', 'LL' => 'Lain-lain'], $maklumat_pemohon ? $maklumat_pemohon->keturunan : '', ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('bumiputra', 'Bumiputra', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Bumiputra</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('bumiputra',[1 => 'Bumiputera', 2 => 'Bumiputera Sabah Sabah', 3 =>'Bumiputera Sarawak', 4 => 'Bukan Bumiputera'],$maklumat_pemohon ? $maklumat_pemohon->bumiputra : '',['placeholder' => 'Sila Pilih','class' => 'form-control form-control-lg ']) }}
                </div>
            </div>
            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('mualaf', 'Mualaf', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Mualaf</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('mualaf', [1 => 'Ya', 0 => 'Tidak'], $maklumat_pemohon ? $maklumat_pemohon->mualaf : '', ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('kewarganegaraan', 'Kewarganegaraan', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Nationality</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('kewarganegaraan', [1 => 'Warganegara', 2 => 'Bukan Warganegara', 3=>'Penduduk Tetap'], $maklumat_pemohon ? $maklumat_pemohon->kewarganegaraan : '', ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg ']) }}
                    <div class="form-text mt-0">Sila nyatakan jika bukan warganegara Malaysia / Please enter if not Malaysian citizen</div>
                </div>
            </div>
            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('kedaaan_fizikal', 'Kedaaan Fizikal', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Physical Condition</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('kedaaan_fizikal', ['N' => 'Tiada Masalah', 'penglihatan' => 'Masalah Penglihatan','pendengaran' => 'Masalah Pendengaran','pembelajaran' => 'Masalah Pembelajaran','pertuturan' => 'Masalah Pertuturan','fizikal'=>'Masalah Fizikal'], $maklumat_pemohon ? $maklumat_pemohon->kedaaan_fizikal : '', ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg ']) }}
                </div>
            </div>
            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('penyakit_kronik', 'Penyakit Kronik', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Chronic Diseases</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('penyakit_kronik[]', [
                        'N' => 'Tiada Penyakit',
                        'alergi' => 'Alergi',
                        'jantung' => 'Jantung',
                        'tibi' => 'Tibi',
                        'asma' => 'Asma',
                        'migrain' => 'Migrain',
                        'pinggang' => 'Buah Pinggang',
                        'kencing manis' => 'Kencing Manis',
                        'darah tinggi' => 'Darah Tinggi',
                        'sakit mental' => 'Sakit Mental',
                        'anxiety disorder' => 'Anxiety Disorder'
                        ], $maklumat_pemohon ? json_decode($maklumat_pemohon->penyakit_kronik) : '', ['class' =>'form-control form-control-lg ', 'data-control'=>'select2', 'multiple'=>'multiple', 'data-placeholder' => 'Sila Pilih']) }}
                </div>
            </div>
            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('rekod_kemasukan_wad', 'Rekod Kemasukan Wad', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Ward Admission Record</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('rekod_kemasukan_wad', ['N' => 'Tiada Rekod', 'MW' => 'Masuk Wad','pembedahan' => 'Pembedahan','RS' => 'Rawatan Psikiatri'], $maklumat_pemohon ? $maklumat_pemohon->rekod_kemasukan_wad : '', ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg ','data-placeholder' => 'Sila Pilih', 'data-hide-search'=>'true']) }}
                </div>
            </div>

        </div>
        <div class="card-footer d-flex justify-content-end">
        </div>
    </div>
</div>
