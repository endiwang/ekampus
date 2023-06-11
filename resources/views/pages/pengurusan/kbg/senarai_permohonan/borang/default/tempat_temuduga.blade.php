<div class="card shadow-none" id="formPermohonanB">
    <div class="card-header border-0">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-dark">B. PILIHAN PUSAT TEMUDUGA (CHOICE OF INTERVIEW CENTER)</span>
        </h3>
    </div>
    <div id="kt_account_settings_profile_details" class="collapse show">
        <form id="kt_account_profile_details_form" class="form">
            <div class="card-body border-top p-9">

                <div class="row mb-6">
                    <div class="col-lg-4">
                        {{ Form::label('pusat_temuduga', '14. Pilihan Pusat Temuduga', ['class' => 'col-form-label required fw-semibold fs-7 pb-0 pt-0']) }}
                        <div class="form-text mt-0">Select Center of Interview</div>
                    </div>
                    <div class="col-lg-8 fv-row">
                        {{ Form::select('pusat_temuduga',$pusat_temuduga, $data->temuduga, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-sm ']) }}
                    </div>
                </div>

            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                {{-- <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Simpan</button> --}}
            </div>
        </form>
    </div>
</div>
