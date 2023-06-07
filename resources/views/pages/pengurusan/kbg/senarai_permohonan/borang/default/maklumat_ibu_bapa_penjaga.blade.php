<div class="card shadow-none" id="formPermohonanE">
    <div class="card-header border-0">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-dark">bapaMAKLUMAT IBU , BAPA DAN PENJAGA</span>
        </h3>
    </div>
    <div id="kt_account_settings_profile_details" class="collapse show">
        <form id="kt_account_profile_details_form" class="form">
            <div class="card-body border-top p-9">

                <div class="row mb-6">
                    <div col-lg-12>
                        <span class="text-black-100 mt-1 fs-7">Maklumat Bapa</span>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('status_bapa', 'Status Bapa', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                {{ Form::select('status_bapa', ['masih_hidup' => 'Masih Hidup', 'meninggal_dunia' => 'Meninggal Dunia'], $data->penjaga->status_bapa == 1 ? 'masih_hidup' : 'meninggal_dunia', ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm', 'v-on:change' => 'maklumatBapa($event)']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('nama_bapa', 'Nama Bapa', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::text('nama_bapa',$data->penjaga->nama_bapa,['class' => 'form-control form-control-sm ']) }}
                    </div>
                </div>

                <div v-show="showMaklumatBapa">

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('ic_no_bapa', 'No. Kad Pengenalan Bapa', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::number('ic_no_bapa',$data->penjaga->no_ic_bapa,['class' => 'form-control form-control-sm ']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('alamat_bapa', 'Alamat Surat-menyurat Bapa', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::textarea('alamat_bapa',$data->penjaga->alamat_surat_bapa,['class' => 'form-control form-control-sm ', 'rows'=>'4']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('poskod_bapa', 'Poskod Bapa', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::number('poskod_bapa',$data->penjaga->poskod_bapa,['class' => 'form-control form-control-sm ']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('no_telefon_bapa', 'No. Telefon Bapa', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::number('no_telefon_bapa',$data->penjaga->no_tel_bapa,['class' => 'form-control form-control-sm ']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('status_pekerjaan_bapa', 'Status Pekerjaan Bapa', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::select('status_pekerjaan_bapa', [1 => 'Bekerja', 2 => 'Tidak Bekerja', 3 => 'Bersara'], $data->penjaga->status_pekerjaan_bapa, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ']) }}
                    </div>
                </div>

                {{-- <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('jenis_pekerjaan_bapa', '35. Jenis Perkerjaan Bapa', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Father's Occupation Type</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::select('jenis_pekerjaan_bapa', ['kerajaan' => 'Kerajaan', 'swasta' => 'Swasta', 'bekerja_sendiri' => 'Bekerja Sendiri'], null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ']) }}
                    </div>
                </div> --}}
                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('pendapatan_bapa', ' Pendapatan Bulanan Bapa', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::number('pendapatan_bapa',$data->penjaga->pendapatan_bapa,['class' => 'form-control form-control-sm ']) }}
                    </div>
                </div>

                </div>

                <div class="separator separator-dashed my-6"></div>


                <div class="row mb-6">
                    <div col-lg-12>
                        <span class="text-black-100 mt-1 fs-7">Maklumat Ibu</span>
                    </div>
                </div>


                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('status_ibu', 'Status Ibu', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::select('status_ibu', ['masih_hidup' => 'Masih Hidup', 'meninggal_dunia' => 'Meninggal Dunia'], $data->penjaga->status_ibu == 1 ? 'masih_hidup' : 'meninggal_dunia', ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm', 'v-on:change' => 'maklumatIbu($event)']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('nama_ibu', 'Nama Ibu', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::text('nama_ibu',$data->penjaga->nama_ibu,['class' => 'form-control form-control-sm ']) }}
                    </div>
                </div>

                <div v-show="showMaklumatIbu">

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('ic_no_ibu', 'No. Kad Pengenalan Ibu', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::number('ic_no_ibu',$data->penjaga->no_ic_ibu,['class' => 'form-control form-control-sm ']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('alamat_ibu', 'Alamat Surat-menyurat Ibu', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::textarea('alamat_ibu',$data->penjaga->alamat_surat_ibu,['class' => 'form-control form-control-sm ', 'rows'=>'4']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('poskod_ibu', 'Poskod Ibu', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::number('poskod_ibu',$data->penjaga->poskod_ibu,['class' => 'form-control form-control-sm ']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('no_telefon_ibu', 'No. Telefon Ibu', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::number('no_telefon_ibu',$data->penjaga->no_tel_ibu,['class' => 'form-control form-control-sm ']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('status_pekerjaan_ibu', 'Status Pekerjaan Ibu', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::select('status_pekerjaan_ibu', [1 => 'Bekerja', 2 => 'Tidak Bekerja', 3 => 'Bersara'], $data->penjaga->status_pekerjaan_ibu, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ']) }}
                    </div>
                </div>

                {{-- <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('jenis_pekerjaan_ibu', 'Jenis Perkerjaan Ibu', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::select('jenis_pekerjaan_ibu', ['kerajaan' => 'Kerajaan', 'swasta' => 'Swasta', 'bekerja_sendiri' => 'Bekerja Sendiri'], null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ']) }}
                    </div>
                </div> --}}

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('pendapatan_ibu', 'Pendapatan Bulanan Ibu', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::number('pendapatan_ibu',$data->penjaga->pendapatan_ibu,['class' => 'form-control form-control-sm ']) }}
                    </div>
                </div>

                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('pemohon_tinggal_bersama', 'Pemohon Tinggal Bersama', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::select('pemohon_tinggal_bersama', [1 => 'Bapa atau Ibu', 2 => 'Penjaga'], $data->penjaga->tingal_bersama, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm', 'v-on:change' => 'maklumatPenjaga($event)']) }}
                    </div>
                </div>


                <div v-show="showMaklumatPenjaga">
                    <div class="separator separator-dashed my-6"></div>

                    <div class="row mb-6">
                        <div col-lg-12>
                            <span class="text-black-100 mt-1 fs-7">Maklumat Penjaga</span>
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-lg-4">
                            {{ Form::label('nama_penjaga', 'Nama Penjaga', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                        </div>
                        <div class="col-lg-8 fv-row">
                            {{ Form::text('nama_penjaga',$data->penjaga->nama_penjaga,['class' => 'form-control form-control-sm ']) }}
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-lg-4">
                            {{ Form::label('ic_no_penjaga', 'No. Kad Pengenalan Penjaga', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                        </div>
                        <div class="col-lg-8 fv-row">
                            {{ Form::number('ic_no_penjaga',$data->penjaga->no_ic_penjaga,['class' => 'form-control form-control-sm ']) }}
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-lg-4">
                            {{ Form::label('alamat_penjaga', 'Alamat Surat-menyurat Penjaga', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                        </div>
                        <div class="col-lg-8 fv-row">
                            {{ Form::textarea('alamat_penjaga',$data->penjaga->alamat_surat_penjaga,['class' => 'form-control form-control-sm ', 'rows'=>'4']) }}
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-lg-4">
                            {{ Form::label('poskod_penjaga', 'Poskod Penjaga', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                        </div>
                        <div class="col-lg-8 fv-row">
                            {{ Form::number('poskod_penjaga',$data->penjaga->poskod_penjaga,['class' => 'form-control form-control-sm ']) }}
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-lg-4">
                            {{ Form::label('no_telefon_penjaga', 'No. Telefon Penjaga', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                        </div>
                        <div class="col-lg-8 fv-row">
                            {{ Form::number('no_telefon_penjaga',$data->penjaga->no_tel_penjaga,['class' => 'form-control form-control-sm ']) }}
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-lg-4">
                            {{ Form::label('status_pekerjaan_penjaga', 'Status Pekerjaan Penjaga', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                        </div>
                        <div class="col-lg-8 fv-row">
                            {{ Form::select('status_pekerjaan_penjaga', [1 => 'Bekerja', 2 => 'Tidak Bekerja', 3 => 'Bersara'], $data->penjaga->status_pekerjaan_penjaga, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ']) }}
                        </div>
                    </div>

                    {{-- <div class="row mb-6">
                        <div class="col-lg-4">
                            {{ Form::label('jenis_pekerjaan_penjaga', 'Jenis Perkerjaan Penjaga', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                        </div>
                        <div class="col-lg-8 fv-row">
                            {{ Form::select('jenis_pekerjaan_penjaga', ['kerajaan' => 'Kerajaan', 'swasta' => 'Swasta', 'bekerja_sendiri' => 'Bekerja Sendiri'], null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ']) }}
                        </div>
                    </div> --}}

                    <div class="row mb-6">
                        <div class="col-lg-4">
                            {{ Form::label('pendapatan_penjaga', 'Pendapatan Bulanan Penjaga', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                        </div>
                        <div class="col-lg-8 fv-row">
                            {{ Form::number('pendapatan_penjaga',$data->penjaga->pendapatan_penjaga,['class' => 'form-control form-control-sm ']) }}
                        </div>
                    </div>

                    <div class="row mb-6">
                        <div class="col-lg-4">
                            {{ Form::label('pertalian_penjaga', 'Pertalian Hubungan', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                        </div>
                        <div class="col-lg-8 fv-row">
                            {{ Form::select('pertalian_penjaga', [1 => 'Bapa Saudara', 2 => 'Datuk',3 => 'Ibu Saudara', 4 => 'Nenek', 5 => 'Lain-lain'], $data->penjaga->pertalian_penjaga, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ']) }}
                        </div>
                    </div>
                </div>

                <div class="separator separator-dashed my-6"></div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('tanggungan_ibu_bapa_penjaga', 'Tanggungan Ibu/Bapa/Penjaga', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                    </div>
                </div>

                {{-- <div class="row mb-6">
                    <div class="d-grid col-lg-12 fv-row">
                        <div class="row mb-6" v-for="(tanggungan_item,index) in tanggungan" :key="tanggungan_item">
                            <div class="col-lg-5 col-md-12 col-12">
                                <input type="text" :name="'tanggungan[' + index + '].nama'" class="form-control form-control-sm " placeholder="Nama / Name" v-model="tanggungan_item.nama">
                            </div>
                            <div class="col-lg-4 col-md-12 col-12 mt-2 mt-md-0 mt-lg-0">
                                <input type="text" :name="'tanggungan[' + index + '].institusi'" class="form-control form-control-sm " placeholder="Institusi / Institution" v-model="tanggungan_item.institusi">
                            </div>
                            <div class="col-lg-2 col-md-8 col-6 mt-2 mt-md-0 mt-lg-0 mt-md-2">
                                <input type="text" :name="'tanggungan[' + index + '].umur'" class="form-control form-control-sm " placeholder="Umur / Age" v-model="tanggungan_item.umur">
                            </div>
                            <div class=" d-grid col-6 col-lg-1 col-md-4 mt-2 mt-md-0 mt-lg-0 mt-md-2">
                                <button type="button" class="btn btn-danger btn-block p-lg-0 p-md-0" @click='removeRowTanggungan(index)'><i class="bi bi-x-circle-fill fs-2 p-0"></i></button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-block" @click='addRowTanggungan' style="margin-right: 3px"><i class="bi bi-plus-circle-fill fs-2"></i>Tambah Maklumat Tanggungan / Add Dependent Information</button>
                    </div>
                </div> --}}

                <div class="row mb-6">
                    {{-- <div class="d-grid col-lg-12 fv-row">
                        <div class="row mb-6" id="template" style="display: none">
                            <div class="col-lg-5 col-md-12 col-12">
                                <input type="text" data-name="tanggungan.nama" class="form-control form-control-sm " placeholder="Nama / Name" >
                            </div>
                            <div class="col-lg-4 col-md-12 col-12 mt-2 mt-md-0 mt-lg-0">
                                <input type="text" data-name="tanggungan.institusi"  class="form-control form-control-sm " placeholder="Institusi / Institution">
                            </div>
                            <div class="col-lg-2 col-md-8 col-6 mt-2 mt-md-0 mt-lg-0 mt-md-2">
                                <input type="text" data-name="tanggungan.umur" class="form-control form-control-sm " placeholder="Umur / Age">
                            </div>
                            <div class=" d-grid col-6 col-lg-1 col-md-4 mt-2 mt-md-0 mt-lg-0 mt-md-2">
                                <button type="button" class="btn btn-danger btn-block p-lg-0 p-md-0 js-remove-button"><i class="bi bi-x-circle-fill fs-2 p-0 js-remove-button-icon"></i></button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-block" id="addButton" style="margin-right: 3px"><i class="bi bi-plus-circle-fill fs-2"></i>Tambah Maklumat Tanggungan / Add Dependent Information</button>
                    </div> --}}

                    <div class="table-responsive">
                        <table class="table table-rounded table-striped border gy-2 gs-7">
                            <thead>
                                <tr class="fw-semibold fs-7 text-gray-800 border-bottom border-gray-200">
                                    <th></th>
                                    <th>Nama</th>
                                    <th>Umur</th>
                                    <th>Institusi</th>
                                    <th class="text-center">Tidakan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($data->tanggungan_penjaga != NULL)
                                    @foreach ($data->tanggungan_penjaga as $index=>$tanggungan)
                                    <tr class="align-middle">
                                        <td>{{ $index+1 }}</td>
                                        <td>{{ $tanggungan->nama }}</td>
                                        <td>{{ $tanggungan->institusi }}</td>
                                        <td class="text-center">{{ $tanggungan->umur }}</td>
                                        <td class="text-center">
                                            <a href="" class="edit btn btn-icon btn-primary btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Pinda"><i class="fa fa-pencil-alt"></i></a>
                                            <a href="" class="edit btn btn-icon btn-danger btn-sm hover-elevate-up mb-1" data-bs-toggle="tooltip" title="Hapus"><i class="fa fa-trash-alt"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
            </div>
        </form>
    </div>
</div>
