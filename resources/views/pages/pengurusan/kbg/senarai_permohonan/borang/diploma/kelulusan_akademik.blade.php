<div class="card mb-5 mb-xl-10" id="formPermohonanC">
    <div class="card-header border-0">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-dark">C. KELULUSAN AKADEMIK (ACADEMIC QUALIFICATION)</span>
            <span class="text-gray-500 mt-1 fw-semibold fs-7">Sila bawa sijil Asal & salinan sijil yang disahkan semasa temuduga / Please bring original and copy of certification on interview</span>
        </h3>
    </div>
    <div id="kt_account_settings_profile_details" class="collapse show">
        <form id="kt_account_profile_details_form" class="form">
            <div class="card-body border-top p-9">

                {{-- <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('nama_sekolah', '15. Nama Sekolah Terakhir', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                        <div class="form-text mt-0">School Name (Last)</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::text('nama_sekolah','',['class' => 'form-control form-control-sm form-control-solid']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('alamat_sekolah', '16. Alamat Sekolah Terakhir', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                        <div class="form-text mt-0">School Addess (Last)</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::textarea('alamat_sekolah','',['class' => 'form-control form-control-sm form-control-solid', 'rows'=>'4']) }}
                    </div>
                </div>

                <div class="separator separator-dashed my-6"></div> --}}

                <div class="row mb-6">
                    <div col-lg-12>
                        <span class="text-black-100 mt-1 fs-7">Maklumat Pengajian Sedia Ada</span>
                        {{-- <span class="text-black-100 mt-1 fs-7">Keputusan Percubaan SIJIL PELAJARAN MALAYSIA (SPM) / SPM TRIAL RESULT</span> --}}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('peringkat_pengajian', '17. Peringkat Pengajian Tertinggi', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::select('peringkat_pengajian',
                            [
                                '1'=>'Sijil Pelajaran Malaysia',
                                '2'=>'Sijil Tinggi Pelajaran Malaysia',
                                '3'=>'Sijil Tinggi Agama Malaysia',
                                '4'=>'Sijil Asas Tahfiz',
                                '5'=>'Sijil Lanjutan',
                                '6'=>'Sijil Kemahiran',
                                '7'=>'Diploma',
                                '8'=>'Diploma Kemahiran',
                                '9'=>'Ijazah Sarjana Muda',
                                '10'=>'Ijazah Sarjana',
                                '11'=>'Doktor Falsafah',
                            ], null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm']) }}
                    </div>
                </div>
                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('tahun_pengajian', '17. Tahun Pengajian', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::select('tahun_pengajian', ['2022' => '2022', '2021' => '2021', '2020' =>'2020'], null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm', 'v-on:change' => 'jenisPeperiksaan($event)']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div col-lg-12>
                        <span class="text-black-100 mt-1 fs-7">Keputusan Peperiksaan</span>
                        {{-- <span class="text-black-100 mt-1 fs-7">Keputusan Percubaan SIJIL PELAJARAN MALAYSIA (SPM) / SPM TRIAL RESULT</span> --}}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('tahun_peperiksaan', '17. Tahun Peperiksaan', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Year of exermination</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::select('tahun_peperiksaan', ['2022' => '2022', '2021' => '2021', '2020' =>'2020'], null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm']) }}
                    </div>
                </div>
                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('jenis_peperiksaan', '17. Jenis Peperiksaan', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Type of exermination</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::select('jenis_peperiksaan', ['spm' => 'Sijil Pelajaran Malaysia (SPM)', 'setara' => 'Sijil-Sijil Lain Yang Setaraf Dengan SPM'], null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm', 'v-on:change' => 'jenisPeperiksaan($event)']) }}
                    </div>
                </div>



                @php
                    $pilihan_keputusan = ['-'=>'-', 'A+' => 'A+', 'A' => 'A', 'A-' =>'A-'];
                @endphp
                <!-- SPM -->
                <div v-show="showResultSPM">
                    <div class="separator separator-dashed my-6"></div>
                    <div class="row mb-6">
                        <div col-lg-12>
                            <span class="text-black-100 mt-1 fs-7">Sijil Pelajaran Malaysia (SPM)</span>
                        </div>
                    </div>
                    <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('pusat_temuduga', '18. Mata Pelajaran & Keputusan', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Subject & Result</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        <div class="row mb-lg-6">
                            @foreach ($subjek_spm as $subjek)
                            <div class="col-lg-4 mt-md-3 mt-3 mt-lg-3">
                                {{ Form::label($subjek->slug, $subjek->nama, ['class' => 'col-form-label fw-semibold fs-7 pb-0 pt-0']) }}
                            </div>
                            <div class="col-lg-2 mt-md-3 mt-3 mt-lg-3 fv-row">
                                {{ Form::select($subjek->slug, $pilihan_keputusan , null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm']) }}
                            </div>
                            @endforeach
                        </div>
                        {{-- <div class="row mb-lg-6">
                            <div class="col-lg-4 mt-md-3 mt-3 mt-lg-0">
                                {{ Form::label('bahasa_melayu', 'Bahasa Melayu', ['class' => 'col-form-label fw-semibold fs-7 pb-0 pt-0']) }}
                                <div class="form-text mt-0">Malay Language</div>
                            </div>
                            <div class="col-lg-2 fv-row">
                                {{ Form::select('bahasa_melayu', $pilihan_keputusan , null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm form-control-solid']) }}
                            </div>

                            <div class="col-lg-4 mt-md-3 mt-3 mt-lg-0">
                                {{ Form::label('al_syariah', 'Al-Syariah', ['class' => 'col-form-label fw-semibold fs-7 pb-0 pt-0']) }}
                            </div>
                            <div class="col-lg-2 fv-row">
                                {{ Form::select('al_syariah', $pilihan_keputusan , null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm form-control-solid']) }}
                            </div>
                        </div>
                        <div class="row mb-lg-6">
                             <div class="col-lg-4 mt-md-3 mt-3 mt-lg-0">
                                {{ Form::label('bahasa_inggeris', 'Bahasa Inggeris', ['class' => 'col-form-label fw-semibold fs-7 pb-0 pt-0']) }}
                                <div class="form-text mt-0">English</div>
                            </div>
                            <div class="col-lg-2 fv-row">
                                {{ Form::select('bahasa_inggeris', $pilihan_keputusan , null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm form-control-solid']) }}
                            </div>

                            <div class="col-lg-4 mt-md-3 mt-3 mt-lg-0">
                                {{ Form::label('turath_dirasat_islamiah', 'Turath Dirasat Islamiah', ['class' => 'col-form-label fw-semibold fs-7 pb-0 pt-0']) }}
                            </div>
                            <div class="col-lg-2 fv-row">
                                {{ Form::select('turath_dirasat_islamiah', $pilihan_keputusan , null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm form-control-solid']) }}
                            </div>
                        </div>
                        <div class="row mb-lg-6">
                            <div class="col-lg-4 mt-md-3 mt-3 mt-lg-0">
                                {{ Form::label('quran_sunnah', 'Pendidikan Al-Quran & Sunnah', ['class' => 'col-form-label fw-semibold fs-7 pb-0 pt-0']) }}
                            </div>
                            <div class="col-lg-2 fv-row">
                                {{ Form::select('quran_sunnah', $pilihan_keputusan , null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm form-control-solid']) }}
                            </div>

                            <div class="col-lg-4 mt-md-3 mt-3 mt-lg-0">
                                {{ Form::label('manahij_al_ulum', 'Manahij Al-Ulum Al-Islamiah', ['class' => 'col-form-label fw-semibold fs-7 pb-0 pt-0']) }}
                            </div>
                            <div class="col-lg-2 fv-row">
                                {{ Form::select('manahij_al_ulum', $pilihan_keputusan , null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm form-control-solid']) }}
                            </div>
                        </div>
                        <div class="row mb-lg-6">
                            <div class="col-lg-4 mt-md-3 mt-3 mt-lg-0">
                                {{ Form::label('syariah_islam', 'Pendidikan Syariah Islam', ['class' => 'col-form-label fw-semibold fs-7 pb-0 pt-0']) }}
                            </div>
                            <div class="col-lg-2 fv-row">
                                {{ Form::select('syariah_islam', $pilihan_keputusan , null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm form-control-solid']) }}
                            </div>

                            <div class="col-lg-4 mt-md-3 mt-3 mt-lg-0">
                                {{ Form::label('maharat_al_quran', 'Maharat Al-Quran', ['class' => 'col-form-label fw-semibold fs-7 pb-0 pt-0']) }}
                            </div>
                            <div class="col-lg-2 fv-row">
                                {{ Form::select('maharat_al_quran', $pilihan_keputusan , null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm form-control-solid']) }}
                            </div>
                        </div>
                        <div class="row mb-lg-6">
                            <div class="col-lg-4 mt-md-3 mt-3 mt-lg-0">
                                {{ Form::label('pendidikan_islam', 'Pendidikan Islam', ['class' => 'col-form-label fw-semibold fs-7 pb-0 pt-0']) }}
                            </div>
                            <div class="col-lg-2 fv-row">
                                {{ Form::select('pendidikan_islam', $pilihan_keputusan , null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm form-control-solid']) }}
                            </div>

                            <div class="col-lg-4 mt-md-3 mt-3 mt-lg-0">
                                {{ Form::label('bahasa_arab', 'Bahasaa Arab', ['class' => 'col-form-label fw-semibold fs-7 pb-0 pt-0']) }}
                            </div>
                            <div class="col-lg-2 fv-row">
                                {{ Form::select('bahasa_arab', $pilihan_keputusan , null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm form-control-solid']) }}
                            </div>
                        </div>
                        <div class="row mb-lg-6">
                            <div class="col-lg-4 mt-md-3 mt-3 mt-lg-0">
                                {{ Form::label('tasawwur_islam', 'Tasawwur Islam', ['class' => 'col-form-label fw-semibold fs-7 pb-0 pt-0']) }}
                            </div>
                            <div class="col-lg-2 fv-row">
                                {{ Form::select('tasawwur_islam', $pilihan_keputusan , null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm form-control-solid']) }}
                            </div>

                            <div class="col-lg-4 mt-md-3 mt-3 mt-lg-0">
                                {{ Form::label('adab_balaghah', 'Al-Adab Wa Al-Balaghah', ['class' => 'col-form-label fw-semibold fs-7 pb-0 pt-0']) }}
                            </div>
                            <div class="col-lg-2 fv-row">
                                {{ Form::select('adab_balaghah', $pilihan_keputusan , null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm form-control-solid']) }}
                            </div>
                        </div>
                        <div class="row mb-lg-6">
                            <div class="col-lg-4 mt-md-3 mt-3 mt-lg-0">
                                {{ Form::label('usuluddin', 'Usuluddin', ['class' => 'col-form-label fw-semibold fs-7 pb-0 pt-0']) }}
                            </div>
                            <div class="col-lg-2 fv-row">
                                {{ Form::select('usuluddin', $pilihan_keputusan , null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm form-control-solid']) }}
                            </div>

                            <div class="col-lg-4 mt-md-3 mt-3 mt-lg-0">
                                {{ Form::label('arabiah_muasirah', 'Al-Lughah Al-Arabiah Al-Mu’asirah', ['class' => 'col-form-label fw-semibold fs-7 pb-0 pt-0']) }}
                            </div>
                            <div class="col-lg-2 fv-row">
                                {{ Form::select('arabiah_muasirah', $pilihan_keputusan , null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm form-control-solid']) }}
                            </div>
                        </div>
                        <div class="row mb-lg-6">
                            <div class="col-lg-4 mt-md-3 mt-3 mt-lg-0">
                                {{ Form::label('quran_sunnah', 'Turath al-Quran dan Sunnah', ['class' => 'col-form-label fw-semibold fs-7 pb-0 pt-0']) }}
                            </div>
                            <div class="col-lg-2 fv-row">
                                {{ Form::select('turath_quran_sunnah', $pilihan_keputusan , null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm form-control-solid']) }}
                            </div>

                            <div class="col-lg-4 mt-md-3 mt-3 mt-lg-0">
                                {{ Form::label('turath_bahasa_arab', 'Turath Bahasa Arab', ['class' => 'col-form-label fw-semibold fs-7 pb-0 pt-0']) }}
                            </div>
                            <div class="col-lg-2 fv-row">
                                {{ Form::select('turath_bahasa_arab', $pilihan_keputusan , null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm form-control-solid']) }}
                            </div>
                        </div> --}}

                    </div>
                    </div>
                </div>
                <!-- SPM End -->
                <!-- Sijil - Sijil Lain -->
                <div v-show="showResultSetara">
                    <div class="separator separator-dashed my-6"></div>
                    <div class="row mb-6">
                        <div col-lg-12>
                            <span class="text-black-100 mt-1 fs-7">Sijil-sijil Yang Setaraf Dengan SPM</span>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-lg-4">
                            {{ Form::label('nama_sijil_lain', '19. Nama Sijil', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                            <div class="form-text mt-0">Certificate Name</div>
                        </div>
                        <div class="col-lg-8 fv-row">
                            {{ Form::text('sijil_lain','',['class' => 'form-control form-control-sm']) }}
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-lg-4">
                            {{ Form::label('nama_peperiksaan_sijil_lain', '21. Nama Peperiksaan', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                            <div class="form-text mt-0">Name of exermination</div>
                        </div>
                        <div class="col-lg-8 fv-row">
                            {{ Form::text('nama_peperiksaan_sijil_lain','',['class' => 'form-control form-control-sm']) }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            {{ Form::label('subject_result_sijil_lain', '22. Mata Pelajaran & Keputusan', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                            <div class="form-text mt-0">Subject & Result</div>
                        </div>
                        {{-- <div class="d-grid col-lg-8 fv-row">
                            <div class="row mb-6" v-for="sijil_lain_item,index in sijil_lain" :key="sijil_lain_item">
                                <div class="col-lg-8 col-md-8 col-12">
                                    <input type="text" name="subject_sijil_lain" class="form-control form-control-sm form-control-solid" placeholder="Nama Mata Pelajaran / Subject Name" v-model="sijil_lain_item.nama_subject_sijil_tambahan">
                                </div>
                                <div class="col-lg-3 col-md-2 col-6 mt-2 mt-md-0 mt-lg-0">
                                    <input type="text" name="keputusan_sijil_lain" class="form-control form-control-sm form-control-solid" placeholder="Gred / Grade" v-model="sijil_lain_item.gred">
                                </div>
                                <div class=" d-grid col-lg-1 col-md-2 col-6 mt-2 mt-md-0 mt-lg-0">
                                    <button type="button" class="btn btn-danger btn-block p-0" @click='removeRowSijilLain(index)'><i class="bi bi-x-circle-fill fs-2 p-0"></i></button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success btn-block" @click='addRowSijilLain' style="margin-right: 3px"><i class="bi bi-plus-circle-fill fs-2"></i>Tambah Mata Pelajaran / Add Subject</button>
                        </div> --}}

                        <div class="d-grid col-lg-8 fv-row">
                            <div class="row mb-6">
                                <div class="col-lg-8 col-md-8 col-12">
                                    <input type="text" class="form-control form-control-sm " name='subjek[0].nama' placeholder="Nama Mata Pelajaran / Subject Name">
                                </div>
                                <div class="col-lg-3 col-md-2 col-6 mt-2 mt-md-0 mt-lg-0">
                                    <input type="text" class="form-control form-control-sm " name='subjek[0].gred' placeholder="Gred / Grade">
                                </div>
                                <div class=" d-grid col-lg-1 col-md-2 col-6 mt-2 mt-md-0 mt-lg-0">
                                </div>
                            </div>

                            <div class="row mb-6" id="template-sijil-setaraf" style="display: none">
                                <div class="col-lg-8 col-md-8 col-12">
                                    <input type="text" data-name="subjek.nama" class="form-control form-control-sm " placeholder="Nama Mata Pelajaran / Subject Name">
                                </div>
                                <div class="col-lg-3 col-md-2 col-6 mt-2 mt-md-0 mt-lg-0">
                                    <input type="text" data-name="subjek.gred" class="form-control form-control-sm " placeholder="Gred / Grade">
                                </div>
                                <div class=" d-grid col-lg-1 col-md-2 col-6 mt-2 mt-md-0 mt-lg-0">
                                    <button type="button" class="btn btn-danger btn-block p-0 js-remove-button-sijil-setaraf"><i class="bi bi-x-circle-fill fs-2 p-0 js-remove-button-sijil-setaraf-icon"></i></button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-success btn-block" id="add-button-sijil-setaraf" style="margin-right: 3px"><i class="bi bi-plus-circle-fill fs-2"></i>Tambah Mata Pelajaran / Add Subject</button>
                        </div>
                    </div>
                </div>

                <!-- Sijil - Sijil Lain End -->
                <!-- STAM -->

                {{-- <div class="separator separator-dashed my-6"></div>

                <div class="row mb-6">
                    <div col-lg-12>
                        <span class="text-black-100 mt-1 fs-7">Sijil Tinggi Agama (STAM) (Jika ada / If any)</span>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('tahun_peperiksaan_stam', '23. Tahun Peperiksaan', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Year of exermination</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::select('tahun_peperiksaan_sijil_lain', ['2022' => '2022', '2021' => '2021', '2020' =>'2020'], null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm form-control-solid']) }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        {{ Form::label('subject_result_sijil_lain', '24. Mata Pelajaran & Keputusan', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Subject & Result</div>
                    </div>
                    <div class="d-grid col-lg-8 fv-row">
                        <div class="row mb-6" v-for="stam_item,index in stam" :key="stam_item">
                            <div class="col-lg-8 col-md-8 col-12">
                                <input type="text" name="subject_sijil_lain" class="form-control form-control-sm form-control-solid" placeholder="Nama Mata Pelajaran / Subject Name" v-model="stam_item.nama_subject_sijil_tambahan">
                            </div>
                            <div class="col-lg-3 col-md-2 col-6 mt-2 mt-md-0 mt-lg-0">
                                <input type="text" name="keputusan_sijil_lain" class="form-control form-control-sm form-control-solid" placeholder="Gred / Grade" v-model="stam_item.gred">
                            </div>
                            <div class=" d-grid col-lg-1 col-md-2 col-6 mt-2 mt-md-0 mt-lg-0">
                                <button type="button" class="btn btn-danger btn-block p-0" @click='removeRowSTAM(index)'><i class="bi bi-x-circle-fill fs-2 p-0"></i></button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-block" @click='addRowSTAM' style="margin-right: 3px"><i class="bi bi-plus-circle-fill fs-2"></i>Tambah Mata Pelajaran / Add Subject</button>
                    </div>
                </div> --}}

                <!-- STAM End -->
            </div>

        </form>
    </div>
</div>
