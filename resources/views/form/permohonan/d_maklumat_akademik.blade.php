<div class="card mb-5 mb-xl-10" id="formPermohonanD">
    <div class="card-header border-0">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-dark">D. MAKLUMAT AKADEMIK PELAJAR (STUDENT ACADEMIC INFORMATION)</span>
        </h3>
    </div>
    <div id="kt_account_settings_profile_details" class="collapse show">
        <form id="kt_account_profile_details_form" class="form">
            <div class="card-body border-top p-9">

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('maklumat_pendidikan_menengah', '25. Maklumat Pendidikan Menengah', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Secondary education information</div>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="d-grid col-lg-12 fv-row">
                        <div class="row mb-6" v-for="pendidikan_menengah_item,index in pendidikan_menengah" :key="pendidikan_menengah_item">
                            <div class="col-lg-6 col-md-8 col-12">
                                <input type="text" name="nama_sekolah_maklumat_pendidikan" class="form-control form-control-lg form-control-solid" placeholder="Nama Sekolah / School Name" v-model="pendidikan_menengah_item.nama_sekolah">
                            </div>
                            <div class="col-lg-2 col-md-4 col-6 mt-2 mt-md-0 mt-lg-0">
                                <input type="text" name="tahun_maklumat_pendidikan" class="form-control form-control-lg form-control-solid" placeholder="Tahun / Year" v-model="pendidikan_menengah_item.tahun">
                            </div>
                            <div class="col-lg-3 col-md-8 col-6 mt-2 mt-md-0 mt-lg-0 mt-md-2">
                                <input type="text" name="keputusan_tertinggi_maklumat_pendidikan" class="form-control form-control-lg form-control-solid" placeholder="Keputusan Tertinggi" v-model="pendidikan_menengah_item.keputusan_tertinggi">
                            </div>
                            <div class=" d-grid col-lg-1 col-md-4 col-12 mt-2 mt-md-0 mt-lg-0 mt-md-2">
                                <button type="button" class="btn btn-danger btn-block p-lg-0 p-md-0" @click='removeRowPendidikanMenengah(index)'><i class="bi bi-x-circle-fill fs-2 p-0"></i></button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-block" @click='addRowPendidikanMenengah' style="margin-right: 3px"><i class="bi bi-plus-circle-fill fs-2"></i>Tambah Maklumat Pendidikan / Add Education Information</button>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-12">
                        {{ Form::label('aktiviti_persatuan', '26. Aktiviti Persatuan/Kelab Dalaman dan Luar Sekolah di Peringkat Menengah', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Assocation activity/Indoor and Outdoor club at the secendory level
                        </div>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="d-grid col-lg-12 fv-row">
                        <div class="row mb-6" v-for="aktiviti_persatuan_item,index in aktiviti_persatuan" :key="aktiviti_persatuan_item">
                            <div class="col-lg-6 col-md-8 col-12 mt-2 mt-lg-0">
                                <input type="text" name="persatuan_aktiviti_persatuan" class="form-control form-control-lg form-control-solid" placeholder="Persatuan / Club" v-model="aktiviti_persatuan_item.persatuan">
                            </div>
                            <div class="col-lg-2 col-md-4 col-6 mt-2 mt-md-0 mt-lg-0 mt-md-2">
                                <input type="text" name="tahun_aktiviti_persatuan" class="form-control form-control-lg form-control-solid" placeholder="Tahun / Year" v-model="aktiviti_persatuan_item.tahun">
                            </div>
                            <div class="col-lg-3 col-md-8 col-6 mt-2 mt-md-0 mt-lg-0 mt-md-2">
                                <input type="text" name="jawatan_aktiviti_persatuan" class="form-control form-control-lg form-control-solid" placeholder="Jawatan / Position" v-model="aktiviti_persatuan_item.jawatan">
                            </div>
                            <div class=" d-grid col-lg-1 col-md-4 col-12 mt-2 mt-md-0 mt-lg-0 mt-md-2">
                                <button type="button" class="btn btn-danger btn-block p-lg-0 p-md-0" @click='removeRowAktivitiPersatuan(index)'><i class="bi bi-x-circle-fill fs-2 p-0"></i></button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-block" @click='addRowAktivitiPersatuan' style="margin-right: 3px"><i class="bi bi-plus-circle-fill fs-2"></i>Tambah Maklumat Aktiviti Persatuan / Add Assocation Activity Information</button>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-12">
                        {{ Form::label('tilawah_hafazan', '27. Sekiranya anda pernah menyertai tilawah Al-Quran atau majlis Hafazan, sila nyatakan', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">If you ever join in recitation of the Al-Quran or memorizing competation
                        </div>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-12">
                        {{ Form::textarea('tilawah_hafazan','',['class' => 'form-control form-control-lg form-control-solid', 'rows'=>'3']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-12">
                        {{ Form::label('cita_cita', '28. Cita-cita dibidang akademik (Sila Nyatakan) : ', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Ambition in academic. (Please indicate)</div>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-12">
                        {{ Form::textarea('cita_cita','',['class' => 'form-control form-control-lg form-control-solid', 'rows'=>'3']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-12">
                        {{ Form::label('sebab_memilih', '29. Sebab utama memilih Darul Quran : ', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">The main reason for chosing Darul Quran :</div>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-12">
                        {{ Form::textarea('sebab_memilih','',['class' => 'form-control form-control-lg form-control-solid', 'rows'=>'3']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-12">
                        {{ Form::label('kursus_dihadiri', '30. Kursus-kursus yang pernah dihadiri dalam tempoh 2 tahun lepas : ', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Courses that i have ever attend in the last 2 years :</div>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-12">
                        {{ Form::textarea('kursus_dihadiri','',['class' => 'form-control form-control-lg form-control-solid', 'rows'=>'3']) }}
                    </div>
                </div>

            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
