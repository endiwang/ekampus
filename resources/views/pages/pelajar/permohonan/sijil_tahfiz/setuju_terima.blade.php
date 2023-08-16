@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <form class="form" action="{{ route('pelajar.permohonan.sijil_tahfiz.setujuTerima.tawaran.jawapan', $permohonan->id)}}" method="post" enctype="multipart/form-data">
                        @method('PATCH')
                        @csrf
                        <div class="card mt-2">
                            <div class="card-body py-5">
                                <h3>Maklumat Peperiksaan Sijil Tahfiz</h3>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('', 'Tarikh Perperiksaan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::label('', date('d/m/Y', strtotime($siri_peperiksaan->tarikh_peperiksaan)), ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('', 'Zon Perperiksaan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::label('', strtoupper($permohonan->pusatPeperiksaan->name), ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                        </div>
                                    </div>
                                </div>
                                <h3>Terima Tawaran</h3>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('status_tawaran', 'Terima Tawaran', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                {{ Form::checkbox('status_tawaran', 1, 0, ['class' => 'form-check-input h-25px w-60px mt-1']); }}
                                                <span class="form-check-label fs-7 fw-semibold mt-2">
                                                    Terima
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('resit_bayaran', 'Resit Bayaran', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <input type="file" name="resit_bayaran" class="{{ 'form-control form-control-sm '.($errors->has('resit_bayaran') ? 'is-invalid':'') }}">
                                            <span class="fs-8 text-muted">Money Order tidak boleh melebihi 6 bulan dari Tarikh peperiksaan</span>
                                            @error('resit_bayaran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <div class="card-body py-5">
                                
                                <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                        <div class="d-flex">
                                            <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                            </button>
                                            <a href="{{ route('pengurusan.pengajian_sepanjang_hayat.tetapan.sesi_peperiksaan_sijil_tahfiz.index') }}" class="btn btn-light btn-sm">Batal</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
            <!--end::Row-->
        </div>
    </div>

@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#ppnegeridiv').show();

    $("#siri_id").on('change', function(){
        var siri_id = this.value;

        $("#pusat_peperiksaan_id").val('');
        $("#pusat_peperiksaan_negeri_id").val('');
        $('#ppnegeridiv').hide();
        $("#pusat_peperiksaan_id").select2({
            ajax: {
                url: "{{route('pelajar.permohonan.sijil_tahfiz.fetchPusatPeperiksaan')}}",
                type: "GET",
                data: {
                            siri_id: siri_id,
                            _token: '{{csrf_token()}}'
                        },
                dataType: 'json',
                processResults: function (data) {
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: data
                };
                }
            }
        })
    })

    $("#pusat_peperiksaan_id").on('change', function(){
        $('#ppnegeridiv').show();
        var pp_id = this.value;

        $("#pusat_peperiksaan_negeri_id").val('');
        $("#pusat_peperiksaan_negeri_id").select2({
            ajax: {
                url: "{{route('pelajar.permohonan.sijil_tahfiz.fetchPusatPeperiksaan.negeri')}}",
                type: "GET",
                data: {
                            pusat_peperiksaan_id: pp_id,
                            _token: '{{csrf_token()}}'
                        },
                dataType: 'json',
                processResults: function (data) {
                // Transforms the top-level key of the response object from 'items' to 'results'
                return {
                    results: data
                };
                }
            }
        })
    })
});
</script>

@endpush
