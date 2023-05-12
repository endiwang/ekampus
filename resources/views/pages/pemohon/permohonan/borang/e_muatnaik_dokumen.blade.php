<div class="card mb-5 mb-xl-10" id="formPermohonanF">
    <div class="card-header border-0">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-dark">MUAT NAIK DOKUMENT</span>
        </h3>
    </div>
    <div id="kt_account_settings_profile_details" class="collapse show">
        {{-- <form id="kt_account_profile_details_form" class="form"> --}}
            <div class="card-body border-top p-9">

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('mykad_passport', 'Salinan MyKad / Passport', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        <input class="form-control" type="file" id="mykad_passport" name="mykad_passport">

                    </div>
                </div>
                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('sijil_spm_setara', 'Salinan Sijil SPM / Setara', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        <input class="form-control" type="file" id="sijil_spm_setara" name="sijil_spm_setara">
                    </div>
                </div>
                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('kad_oku', 'Salinan Kad OKU (Jika berkenaan)', ['class' => 'col-form-label fw-semibold fs-6 pb-0 pt-0']) }}
                    </div>
                    <div class="col-lg-8 fv-row">
                        <input class="form-control" type="file" id="kad_oku" name="kad_oku">
                    </div>
                </div>

            </div>

        {{-- </form> --}}
    </div>
</div>
