<div class="card shadow-none" id="formPermohonanA">
    <div class="card-header border-0">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-dark">A. MAKLUMAT PEMOHON (PERSONAL PARTICULARS)</span>
        </h3>
    </div>
    <div id="kt_account_settings_profile_details" class="collapse show">
        <div class="card-body border-top p-9">
            <div class="row mb-6">
                <div class="col-lg-4">
                    <label class="col-form-label fw-semibold fs-6 required pb-0 pt-0"`>Gambar</label>
                    <div class="form-text mt-0">Picture</div>
                </div>
                <div class="col-lg-8">
                    <div class="image-input image-input-outline image-input-empty" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
                        <!--begin::Preview existing avatar-->
                        <div class="image-input-wrapper w-125px h-125px"></div>
                        <!--end::Preview existing avatar-->

                        <!--begin::Label-->
                        <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                            <i class="bi bi-pencil-fill fs-7"></i>

                            <!--begin::Inputs-->
                            <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
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
                    <!--end::Image input-->
                    <div class="form-text">Format gambar yang dibenarkan / Allowed picture format: png, jpg, jpeg.</div>
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('nama_pemohon', '1. Nama Penuh', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Full Name</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::text('nama_pemohon','',['class' => 'form-control form-control-lg ']) }}
                    <div class="form-text">Nama penuh mengikut K.P / Full name according to your IC</div>
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('nama_jawi', '2. Nama Jawi', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Jawi Name</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::text('nama_jawi','',['class' => 'form-control form-control-lg ']) }}
                    <a href="https://www.arabic-keyboard.org/" target="blank">www.arabic-keyboard.org </a>
                    <div class="form-text mt-0">Sila salin "Copy" dan "Paste" semula di dalam ruangan NAMA JAWI. </div>
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('no_kp', '3. No. Kad Pengenalan / Pasport', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">I/C Number / Passport</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::number('no_kp','',['class' => 'form-control form-control-lg ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('tarikh_lahir', '4. Tarikh Lahir', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Date of Birth</div>
                </div>
                <div class="col-lg-8 fv-row">
                    <input class="form-control form-control-lg "name="tarikh_lahir" id="tarikh_lahir"/>
                    {{-- {{ Form::date('tarikh_lahir','',['class' => 'form-control form-control-lg ']) }} --}}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('alamat_emel', '3. Alamat Emel', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Email Address</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::email('alamat_emel','',['class' => 'form-control form-control-lg ']) }}
                    <div class="form-text mt-0">Sila masukkan alamat emel yang sah untuk dihubungi / Please enter a valid email address to be contacted</div>
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('alamat_tetap', '4. Alamat Tetap', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Fixed Address</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::textarea('alamat_tetap','',['class' => 'form-control form-control-lg ', 'rows'=>'4']) }}
                    <div class="form-text mt-0">Sila masukkan alamat tetap mengikut kad pengenalan / Please your enter fixed address according to the identification card</div>

                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('alamat_rumah', '5. Alamat Surat-menyurat', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Mailing Address</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::textarea('alamat_rumah','',['class' => 'form-control form-control-lg ', 'rows'=>'4']) }}
                    <div class="form-text mt-0">Sila masukkan alamat surat-menyurat anda / Please your enter mailing address</div>

                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('poskod', '5. Poskod', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Postcode</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::number('poskod','',['class' => 'form-control form-control-lg ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('no_telefon', '6. No. Telefon', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Phone Number</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::number('no_telefon','',['class' => 'form-control form-control-lg ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('jantina', '7. Jantina', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Gender</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('jantina', ['L' => 'Lelaki (Male)', 'P' => 'Perempuan (Female)'], null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg ']) }}
                </div>
            </div>



            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('negeri_kelahiran', '10. Negeri Kelahiran', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">State of Birth</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('negeri_kelahiran', ['P' => 'Perak', 'N9' => 'Negeri Sembilan', 'S' =>'Selangor'], null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('keturunan', '11. Keturunan', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Race</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('keturunan', ['M' => 'Melayu', 'C' => 'Cina', 'I' =>'India', 'OS' => 'Orang Asli', 'LL' => 'Lain-lain'], null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('bumiputra', '12. Bumiputra', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Bumiputra</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('bumiputra',['B' => 'Bumiputera', 'BSB' => 'Bumiputera Sabah Sabah', 'BSR' =>'Bumiputera Sarawak', 'BB' => 'Bukan Bumiputera'],null,['placeholder' => 'Sila Pilih','class' => 'form-control form-control-lg ']) }}
                </div>
            </div>
            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('mualaf', '13. Mualaf', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Mualaf</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('mualaf', ['Y' => 'Ya', 'N' => 'Tidak'], null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('kewarganegaraan', '14. Kewarganegaraan', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Nationality</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('kewarganegaraan', ['W' => 'Warganegara', 'BW' => 'Bukan Warganegara','PT'=>'Penduduk Tetap'], null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg ']) }}
                    <div class="form-text mt-0">Sila nyatakan jika bukan warganegara Malaysia / Please enter if not Malaysian citizen</div>
                </div>
            </div>
            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('kedaaan_fizikal', '15. Kedaaan Fizikal', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Physical Condition</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('kedaaan_fizikal', ['N' => 'Tiada Masalah', 'penglihatan' => 'Masalah Penglihatan','pendengaran' => 'Masalah Pendengaran','pembelajaran' => 'Masalah Pembelajaran','pertuturan' => 'Masalah Pertuturan','fizikal'=>'Masalah Fizikal'], null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg ']) }}
                </div>
            </div>
            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('penyakit_kronik', '16. Penyakit Kronik', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Chronic Diseases</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('penyakit_kronik', [
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
                        ], null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg ']) }}
                </div>
            </div>
            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('rekod_kemasukan_wad', '17. Rekod Kemasukan Wad', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    <div class="form-text mt-0">Ward Admission Record</div>
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('rekod_kemasukan_wad', ['N' => 'Tiada Rekod', 'MW' => 'Masuk Wad','pembedahan' => 'Pembedahan','RS' => 'Rawatan Psikiatri'], null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg ']) }}
                </div>
            </div>




        </div>
        <div class="card-footer d-flex justify-content-end">
        </div>
    </div>
</div>
