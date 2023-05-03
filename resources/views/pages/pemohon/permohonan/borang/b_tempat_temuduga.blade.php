<div class="card shadow-none" id="formPermohonanB">
    <div class="card-header border-0">
        <h3 class="card-title align-items-start flex-column">
            <span class="card-label fw-bold text-dark">PILIHAN PUSAT PENGAJIAN DAN TEMUDUGA</span>
        </h3>
    </div>
    <div id="kt_account_settings_profile_details" class="collapse show">
        {{-- <form id="kt_account_profile_details_form" class="form"> --}}
            <div class="card-body border-top p-9">
                @foreach ($permohonan as $index => $permohonan_data)
                    <div class="row mb-6">
                        <div class="col-lg-4">
                            {{ Form::label('pusat_temuduga', $permohonan_data->pusat_pengajian->nama, ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                            <div class="form-text mt-0">Pusat Pengajian</div>
                        </div>
                        {{-- <div class="col-lg-8 fv-row">
                            <!--begin::Col-->
                            <div class="offset-lg-4 col-lg-8">
                                <label class="form-check form-check-custom form-check-inline">
                                    <input class="form-check-input" name="status_{{$permohonan_data->id}}" id="status_{{$permohonan_data->id}}" type="checkbox" value="1"/>
                                    <span class="fw-semibold ps-2 fs-7 text-capitalize">Pilih</span>
                                </label>
                            </div>
                            <!--end::Col-->
                        </div> --}}
                        <div class="col-lg-8 fv-row">
                            <label class="form-check form-check-custom form-check-solid">
                                {{-- {{ Form::checkbox('status_'.$permohonan_data->id, '1', false, ['class' => 'form-check-input h-25px w-60px','id'=>'status_'.$permohonan_data->id, 'onclick' => 'status'.$permohonan_data->id.'()' ]); }} --}}
                                <input class="form-check-input" name="pilih_pusat_pengajian_{{$index+1}}" id="status_{{$index+1}}" onclick="status{{$index+1}}()" type="checkbox" value="1"/>
                                <span class="form-check-label fs-6 fw-semibold ">
                                    Pilih
                                </span>
                            </label>
                        </div>
                        <input type="hidden" name="permohonan_id[{{ $permohonan_data->id }}]" value="{{ $permohonan_data->id }}">
                    </div>
                    <div class="row mb-6">
                        <div class="col-lg-4">
                            {{ Form::label('pusat_temuduga_'.$index+1, 'Pilihan Pusat Temuduga', ['class' => 'col-form-label required fw-semibold fs-6 pb-0 pt-0']) }}
                        </div>
                        <div class="col-lg-8 fv-row">
                            {{ Form::select('pusat_temuduga_'.$index+1, $permohonan_data->pusat_temuduga, null, ['placeholder' => 'Sila Pilih','class' =>'form-control form-control-lg ', 'disabled' => 'disabled', 'id'=>'status_pilihan_'.$index+1,]) }}
                        </div>
                    </div>

                    <div class="separator separator-dashed my-6"></div>

                    <script>
                        function status{{ $index+1 }}() {
                            var status = $("#status_{{$index+1}}").is(':checked');
                            if(status == true)
                            {
                                $("#status_pilihan_{{$index+1}}").prop('disabled', false);
                                bahagianB.enableValidator('pusat_temuduga_{{ $index+1 }}', 'notEmpty');
                            }else{
                                $("#status_pilihan_{{$index+1}}").val('');
                                $("#status_pilihan_{{$index+1}}").prop('disabled', true);
                                bahagianB.disableValidator('pusat_temuduga_{{ $index+1 }}', 'notEmpty');
                            }
                        }

                    </script>

                @endforeach
            </div>

            <div class="card-footer d-flex justify-content-end py-6 px-9">
                {{-- <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Simpan</button> --}}
            </div>
        {{-- </form> --}}
    </div>
</div>
