<div class="card mb-5 mb-xl-10" id="formPermohonanG">
    <div class="card-header border-0">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-dark">PERAKUAN PEMOHON</span>
        </h3>
    </div>
    <div id="kt_account_settings_profile_details" class="collapse show">
        {{-- <form id="kt_account_profile_details_form" class="form"> --}}
            <div class="card-body border-top p-9">

                <div class="row mb-6">
                    <div class="col-lg-12">
                        {{ Form::label('', 'Sila tandakan kotak ini jika anda benar-benar pasti untuk menghantar permohonan ini.', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    </div>
                </div>

                <div class="row mb-6">
                    <div class="col-lg-12">
                        <label class="form-check form-check-custom form-check-solid">
                            {{-- {{ Form::checkbox('status_'.$permohonan_data->id, '1', false, ['class' => 'form-check-input h-25px w-60px','id'=>'status_'.$permohonan_data->id, 'onclick' => 'status'.$permohonan_data->id.'()' ]); }} --}}
                            <input class="form-check-input" id="perakuan_pemohon"  name="perakuan_pemohon" type="checkbox" value="1"/>
                            <span class="form-check-label fs-6 fw-semibold ">
                                Saya mengaku bahawa keterangan dan maklumat yang diberikan benar. Saya akui bahawa pihak Darul Quran berhak menolak permohonan ini sekiranya mana-mana keterangan, maklumat atau salinan-salinan sijil yang dikemukakan adalah tidak benar.                            </span>
                        </label>
                    </div>
                </div>

            </div>

        {{-- </form> --}}
    </div>
</div>
