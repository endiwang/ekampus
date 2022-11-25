<div class="card mb-5 mb-xl-10" id="formPermohonanE">
    <div class="card-header border-0">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-dark">D. MAKLUMAT IBU / BAPA / PENJAGA (MOTHER / FATHER / GUARDIAN INFORMATION)</span>
        </h3>
    </div>
    <div id="kt_account_settings_profile_details" class="collapse show">
        <form id="kt_account_profile_details_form" class="form">
            <div class="card-body border-top p-9">

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('nama_ibu_bapa_penjaga', '31. Nama', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Name</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::text('nama_ibu_bapa_penjaga','',['class' => 'form-control form-control-lg form-control-solid']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('ic_no_ibu_bapa_penjaga', '32. No. Kad Pengenalan', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">IC Number</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::number('ic_no_ibu_bapa_penjaga','',['class' => 'form-control form-control-lg form-control-solid']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('alamat_rumah_ibu_bapa_penjaga', '33. Alamat Surat-menyurat', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Mailing Address</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::textarea('alamat_rumah_ibu_bapa_penjaga','',['class' => 'form-control form-control-lg form-control-solid', 'rows'=>'4']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('poskod_ibu_bapa_penjaga', '34. Poskod', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Postcode</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::number('poskod_ibu_bapa_penjaga','',['class' => 'form-control form-control-lg form-control-solid']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('no_telefon_ibu_bapa_penjaga', '35. No. Telefon', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Phone Number</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::number('no_telefon_ibu_bapa_penjaga','',['class' => 'form-control form-control-lg form-control-solid']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('pertalian_ibu_bapa_penjaga', '36. Pertalian Hubungan', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Relationship</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::select('pertalian_ibu_bapa_penjaga', ['bapa' => 'Bapa', 'bapa_saudara' => 'Bapa Saudara', 'datuk' => 'Datuk', 'ibu' => 'Ibu', 'ibu_saudara' => 'Ibu Saudara', 'nenek' => 'Nenek',], null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg form-control-solid']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('pekerjaan_ibu_bapa_penjaga', '37. Pekerjaan', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Occupation</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::text('pekerjaan_ibu_bapa_penjaga','',['class' => 'form-control form-control-lg form-control-solid']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('pendapatan_ibu_bapa_penjaga', '38. Pendapatan Bulanan Ibu/Bapa/Penjaga', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Monthly Income (Mother/Father/Guardian)</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::number('pendapatan_ibu_bapa_penjaga','',['class' => 'form-control form-control-lg form-control-solid']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('tanggungan_ibu_bapa_penjaga', '39. Tanggungan Ibu/Bapa/Penjaga', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Dependents of Mother/Father/Guardian</div>
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="d-grid col-lg-12 fv-row">
                        <div class="row mb-6" v-for="tanggungan_item,index in tanggungan" :key="tanggungan_item">
                            <div class="col-lg-5 col-md-12 col-12">
                                <input type="text" name="nama_tanggungan" class="form-control form-control-lg form-control-solid" placeholder="Nama / Name" v-model="tanggungan_item.nama">
                            </div>
                            <div class="col-lg-4 col-md-12 col-12 mt-2 mt-md-0 mt-lg-0">
                                <input type="text" name="institusi_tanggungan" class="form-control form-control-lg form-control-solid" placeholder="Institusi / Institution" v-model="tanggungan_item.institusi">
                            </div>
                            <div class="col-lg-2 col-md-8 col-6 mt-2 mt-md-0 mt-lg-0 mt-md-2">
                                <input type="text" name="umur_tanggungan" class="form-control form-control-lg form-control-solid" placeholder="Umur / Age" v-model="tanggungan_item.umur">
                            </div>
                            <div class=" d-grid col-6 col-lg-1 col-md-4 mt-2 mt-md-0 mt-lg-0 mt-md-2">
                                <button type="button" class="btn btn-danger btn-block p-lg-0 p-md-0" @click='removeRowTanggungan(index)'><i class="bi bi-x-circle-fill fs-2 p-0"></i></button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success btn-block" @click='addRowTanggungan' style="margin-right: 3px"><i class="bi bi-plus-circle-fill fs-2"></i>Tambah Maklumat Tanggungan / Add Dependent Information</button>
                    </div>
                </div>

            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Simpan</button>
            </div>
        </form>
    </div>
</div>
