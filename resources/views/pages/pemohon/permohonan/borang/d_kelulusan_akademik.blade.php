<div class="card mb-5 mb-xl-10" id="formPermohonanC">
    <div class="card-header border-0">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-dark">KELULUSAN AKADEMIK (ACADEMIC QUALIFICATION)</span>
            <span class="text-gray-500 mt-1 fw-semibold fs-6">Sila bawa sijil Asal & salinan sijil yang disahkan semasa temuduga / Please bring original and copy of certification on interview</span>
        </h3>
    </div>
    <div id="kt_account_settings_profile_details" class="collapse show">
        {{-- <form id="kt_account_profile_details_form" class="form"> --}}
            <div class="card-body border-top p-9">

                {{-- <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('nama_sekolah', '15. Nama Sekolah Terakhir', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">School Name (Last)</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::text('nama_sekolah','',['class' => 'form-control form-control-lg form-control-solid']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('alamat_sekolah', '16. Alamat Sekolah Terakhir', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">School Addess (Last)</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::textarea('alamat_sekolah','',['class' => 'form-control form-control-lg form-control-solid', 'rows'=>'4']) }}
                    </div>
                </div>

                <div class="separator separator-dashed my-6"></div> --}}

                <div class="row mb-6">
                    <div col-lg-12>
                        <span class="text-black-100 mt-1 fs-6">Keputusan Peperiksaan</span>
                        {{-- <span class="text-black-100 mt-1 fs-6">Keputusan Percubaan SIJIL PELAJARAN MALAYSIA (SPM) / SPM TRIAL RESULT</span> --}}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('tahun_peperiksaan', 'Tahun Peperiksaan', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Year of exermination</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::select('tahun_peperiksaan', ['2022' => '2022', '2021' => '2021', '2020' =>'2020'], null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg']) }}
                    </div>
                </div>
                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('jenis_peperiksaan', 'Jenis Peperiksaan', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Type of exermination</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::select('jenis_peperiksaan', ['spm' => 'Sijil Pelajaran Malaysia (SPM)', 'setara' => 'Sijil-Sijil Lain Yang Setaraf Dengan SPM'], null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg', 'v-on:change' => 'jenisPeperiksaan($event)']) }}
                    </div>
                </div>



                @php
                    $pilihan_keputusan = ['-'=>'-', 'A+' => 'A+', 'A' => 'A', 'A-' =>'A-', 'B+' => 'B+','B' => 'B', 'C+' => 'C+','C'=>'C','D'=>'D','E'=>'E','G'=>'G'];
                @endphp
                <!-- SPM -->
                <div v-show="showResultSPM">
                    <div class="separator separator-dashed my-6"></div>
                    <div class="row mb-6">
                        <div col-lg-12>
                            <span class="text-black-100 mt-1 fs-6">Sijil Pelajaran Malaysia (SPM)</span>
                        </div>
                    </div>
                    <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('pusat_temuduga', 'Mata Pelajaran & Keputusan', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Subject & Result</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        <div class="row mb-lg-6">
                            @foreach ($subjek_spm as $subjek)
                            <div class="col-lg-4 mt-md-3 mt-3 mt-lg-3">
                                {{ Form::label($subjek->slug, $subjek->nama, ['class' => 'col-form-label fw-semibold fs-6 pb-0 pt-0']) }}
                            </div>
                            <div class="col-lg-2 mt-md-3 mt-3 mt-lg-3 fv-row">
                                {{ Form::select($subjek->slug, $pilihan_keputusan , null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg']) }}
                            </div>
                            @endforeach
                        </div>
                    </div>
                    </div>
                </div>
                <!-- SPM End -->
                <!-- Sijil - Sijil Lain -->
                <div v-show="showResultSetara">
                    <div class="separator separator-dashed my-6"></div>
                    <div class="row mb-6">
                        <div col-lg-12>
                            <span class="text-black-100 mt-1 fs-6">Sijil-sijil Yang Setaraf Dengan SPM</span>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-lg-4">
                            {{ Form::label('nama_sijil_lain', 'Nama Sijil', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                            <div class="form-text mt-0">Certificate Name</div>
                        </div>
                        <div class="col-lg-8 fv-row">
                            {{ Form::text('sijil_lain','',['class' => 'form-control form-control-lg']) }}
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-lg-4">
                            {{ Form::label('nama_peperiksaan_sijil_lain', 'Nama Peperiksaan', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                            <div class="form-text mt-0">Name of exermination</div>
                        </div>
                        <div class="col-lg-8 fv-row">
                            {{ Form::text('nama_peperiksaan_sijil_lain','',['class' => 'form-control form-control-lg']) }}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            {{ Form::label('subject_result_sijil_lain', 'Mata Pelajaran & Keputusan', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                            <div class="form-text mt-0">Subject & Result</div>
                        </div>

                        <div class="d-grid col-lg-8 fv-row">
                            <div class="row mb-6">
                                <div class="col-lg-8 col-md-8 col-12">
                                    <input type="text" class="form-control form-control-lg " name='subjek_nama[0]' placeholder="Nama Mata Pelajaran / Subject Name">
                                </div>
                                <div class="col-lg-3 col-md-2 col-6 mt-2 mt-md-0 mt-lg-0">
                                    <input type="text" class="form-control form-control-lg " name='subjek_gred[0]' placeholder="Gred / Grade">
                                </div>
                                <div class=" d-grid col-lg-1 col-md-2 col-6 mt-2 mt-md-0 mt-lg-0">
                                </div>
                            </div>

                            <div class="row mb-6" id="template-sijil-setaraf" style="display: none">
                                <div class="col-lg-8 col-md-8 col-12">
                                    <input type="text" data-name="subjek.nama" class="form-control form-control-lg " placeholder="Nama Mata Pelajaran / Subject Name">
                                </div>
                                <div class="col-lg-3 col-md-2 col-6 mt-2 mt-md-0 mt-lg-0">
                                    <input type="text" data-name="subjek.gred" class="form-control form-control-lg " placeholder="Gred / Grade">
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
                        <span class="text-black-100 mt-1 fs-6">Sijil Tinggi Agama (STAM) (Jika ada / If any)</span>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('tahun_peperiksaan_stam', '23. Tahun Peperiksaan', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Year of exermination</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::select('tahun_peperiksaan_sijil_lain', ['2022' => '2022', '2021' => '2021', '2020' =>'2020'], null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg form-control-solid']) }}
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        {{ Form::label('subject_result_sijil_lain', '24. Mata Pelajaran & Keputusan', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Subject & Result</div>
                    </div>
                    <div class="d-grid col-lg-8 fv-row">
                        <div class="row mb-6" v-for="stam_item,index in stam" :key="stam_item">
                            <div class="col-lg-8 col-md-8 col-12">
                                <input type="text" name="subject_sijil_lain" class="form-control form-control-lg form-control-solid" placeholder="Nama Mata Pelajaran / Subject Name" v-model="stam_item.nama_subject_sijil_tambahan">
                            </div>
                            <div class="col-lg-3 col-md-2 col-6 mt-2 mt-md-0 mt-lg-0">
                                <input type="text" name="keputusan_sijil_lain" class="form-control form-control-lg form-control-solid" placeholder="Gred / Grade" v-model="stam_item.gred">
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

        {{-- </form> --}}
    </div>
</div>
