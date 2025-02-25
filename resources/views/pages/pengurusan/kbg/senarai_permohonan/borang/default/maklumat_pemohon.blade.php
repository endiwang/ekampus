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
                    <label class="col-form-label fw-semibold fs-7 required pb-0 pt-0"`>Gambar</label>
                    <div class="form-text mt-0">Picture</div>
                </div>
                <div class="col-lg-8">
                    <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
                        <!--begin::Preview existing avatar-->
                        <div class="image-input-wrapper w-125px h-125px" style="background-image: url('{{ asset($data->gambar)}}')"></div>
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
                    {{-- <div class="image-input image-input-outline image-input-empty" data-kt-image-input="true" style="background-image: url('assets/media/svg/avatars/blank.svg')">
                        <!--begin::Preview existing avatar-->
                        <div class="image-input-wrapper w-125px h-125px" style="background-image: url('{{ asset($data->gambar)}}')"></div>
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
                    </div> --}}
                    <!--end::Image input-->
                    <div class="form-text">Format gambar yang dibenarkan / Allowed picture format: png, jpg, jpeg.</div>
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('nama_pemohon', 'Nama Penuh', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::text('nama_pemohon',$data->nama,['class' => 'form-control form-control-sm ']) }}
                    <div class="form-text">Nama penuh mengikut K.P / Full name according to your IC</div>
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('nama_jawi', 'Nama Jawi', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::text('nama_jawi',$data->nama_jawi,['class' => 'form-control form-control-sm ']) }}
                    <a href="https://www.arabic-keyboard.org/" target="blank">www.arabic-keyboard.org </a>
                    <div class="form-text mt-0">Sila salin "Copy" dan "Paste" semula di dalam ruangan NAMA JAWI. </div>
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('no_kp', 'No. Kad Pengenalan / Pasport', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::number('no_kp',$data->no_ic,['class' => 'form-control form-control-sm ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('tarikh_lahir', 'Tarikh Lahir', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                </div>
                <div class="col-lg-8 fv-row">
                    <input class="form-control form-control-sm "name="tarikh_lahir" id="tarikh_lahir" value="{{ $data->tarikh_lahir ?? '' }}"/>
                    {{-- {{ Form::date('tarikh_lahir','',['class' => 'form-control form-control-sm ']) }} --}}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('alamat_emel', 'Alamat Emel', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::email('alamat_emel',$data->email,['class' => 'form-control form-control-sm ']) }}
                    <div class="form-text mt-0">Sila masukkan alamat emel yang sah untuk dihubungi / Please enter a valid email address to be contacted</div>
                </div>
            </div>

            <div class="separator separator-dashed my-6"></div>

            <div class="row mb-6">
                <div col-lg-12="">
                    <label for="" class="col-form-label fw-semibold fs-7 pb-0 pt-0">Alamat Tetap</label>
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('alamat_tetap', 'Alamat Penuh', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::textarea('alamat_tetap',$data->alamat_tetap,['class' => 'form-control form-control-sm ', 'rows'=>'4']) }}
                    <div class="form-text mt-0">Sila masukkan alamat tetap mengikut kad pengenalan / Please your enter fixed address according to the identification card</div>

                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('bandar_tetap', 'Bandar', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::text('bandar_tetap',$data->bandar,['class' => 'form-control form-control-sm ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('poskod_tetap', 'Poskod', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::text('poskod_tetap',$data->poskod,['class' => 'form-control form-control-sm ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('negeri_kelahiran', 'Negeri', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('negeri_kelahiran', $negeri , $data->negeri_id, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('alamat_rumah', 'Alamat Surat-menyurat', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::textarea('alamat_rumah',$data->alamat_surat,['class' => 'form-control form-control-sm ', 'rows'=>'4']) }}
                    <div class="form-text mt-0">Sila masukkan alamat surat-menyurat anda / Please your enter mailing address</div>

                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('no_telefon', 'No. Telefon', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::text('no_telefon',$data->no_tel,['class' => 'form-control form-control-sm ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('jantina', 'Jantina', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('jantina', ['L' => 'Lelaki (Male)', 'P' => 'Perempuan (Female)'], $data->jantina, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ']) }}
                </div>
            </div>



            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('negeri_kelahiran', 'Negeri Kelahiran', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('negeri_kelahiran', $negeri , $data->negeri_kelahiran_id, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('keturunan', 'Keturunan', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('keturunan', $keturunan, $data->keturunan_id, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('bumiputra', 'Bumiputra', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('bumiputra',[1 => 'Bumiputera', 2 => 'Bumiputera Sabah Sabah', 3 =>'Bumiputera Sarawak', 4 => 'Bukan Bumiputera'],$data->bumiputra,['placeholder' => 'Sila Pilih','class' => 'form-control form-control-sm ']) }}
                </div>
            </div>
            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('mualaf', 'Mualaf', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('mualaf', [1 => 'Ya', 2 => 'Tidak'], $data->mualaf, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ']) }}
                </div>
            </div>

            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('kewarganegaraan', 'Kewarganegaraan', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('kewarganegaraan', [1 => 'Warganegara', 2 => 'Bukan Warganegara', 3=>'Penduduk Tetap'], $data->warganegara, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ']) }}
                </div>
            </div>
            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('kedaaan_fizikal', 'Kedaaan Fizikal', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('kedaaan_fizikal', ['N' => 'Tiada Masalah', 'penglihatan' => 'Masalah Penglihatan','pendengaran' => 'Masalah Pendengaran','pembelajaran' => 'Masalah Pembelajaran','pertuturan' => 'Masalah Pertuturan','fizikal'=>'Masalah Fizikal'], $data->kedaaan_fizikal, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ']) }}
                </div>
            </div>
            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('penyakit_kronik', 'Penyakit Kronik', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
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
                        ], json_decode($data->penyakit_kronik), ['class' =>'form-control form-control-sm ', 'data-control'=>'select2', 'multiple'=>'multiple', 'data-placeholder' => 'Sila Pilih']) }}
                </div>
            </div>
            <div class="row mb-6">
                <div class="col-lg-4">
                    {{ Form::label('rekod_kemasukan_wad', 'Rekod Kemasukan Wad', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                </div>
                <div class="col-lg-8 fv-row">
                    {{ Form::select('rekod_kemasukan_wad', ['N' => 'Tiada Rekod', 'MW' => 'Masuk Wad','pembedahan' => 'Pembedahan','RS' => 'Rawatan Psikiatri'], $data->rekod_kemasukan_wad, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ','data-placeholder' => 'Sila Pilih', 'data-hide-search'=>'true']) }}
                </div>
            </div>




        </div>
        <div class="card-footer d-flex justify-content-end">
        </div>
    </div>
</div>
