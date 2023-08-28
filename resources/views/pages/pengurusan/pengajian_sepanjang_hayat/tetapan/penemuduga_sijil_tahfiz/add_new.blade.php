@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <form class="form" action="{{ route('pengurusan.pengajian_sepanjang_hayat.tetapan.penemuduga_sijil_tahfiz.store')}}" method="post">
                        @csrf
                        <div class="card">
                            <div class="card-body py-5">
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('staff_id', 'Penemuduga', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <select name="staff_id" class="form-select" data-control="select2" data-placeholder="Sila Pilih" data-allow-clear="true" data-hide-search="false">
                                                @foreach ($staffSelection as $staff)
                                                    <option value="{{ $staff->id }}">{{ $staff->nama }}</option>
                                                @endforeach
                                            </select>
                                            @error('staff') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tetapan_peperiksaan_sijil_tahfiz_id', 'Siri peperiksaan sijil tahfiz', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <select name="tetapan_peperiksaan_sijil_tahfiz_id" class="form-select" data-control="select2" data-placeholder="Sila Pilih" data-allow-clear="true" data-hide-search="false" id="tetapan_peperiksaan_sijil_tahfiz_id">
                                                @foreach ($tetapanpeperiksaansijiltahfizs as $tetapanpeperiksaansijiltahfiz)
                                                    <option value="{{ $tetapanpeperiksaansijiltahfiz->id }}">{{ $tetapanpeperiksaansijiltahfiz->siri }}</option>
                                                @endforeach
                                            </select>
                                            @error('tetapan_peperiksaan_sijil_tahfiz_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('pusat_peperiksaan_id', 'Pusat Peperiksaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('pusat_peperiksaan_id', [], old('pusat_peperiksaan_id'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('pusat_peperiksaan_id') ? 'is-invalid':''),'id'=>'pusat_peperiksaan_id' ]) }}
                                            @error('pusat_peperiksaan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" id="ppnegeridiv">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('pusat_peperiksaan_negeri_id', 'Negeri Pusat Peperiksaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('pusat_peperiksaan_negeri_id', [], old('pusat_peperiksaan_negeri_id'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('pusat_peperiksaan_negeri_id') ? 'is-invalid':''),'id'=>'pusat_peperiksaan_negeri_id' ]) }}
                                            @error('pusat_peperiksaan_negeri_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('status', 'Status', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                {{ Form::checkbox('status', 1, 0, ['class' => 'form-check-input h-25px w-60px mt-1']); }}
                                                <span class="form-check-label fs-7 fw-semibold mt-2">
                                                    Aktif
                                                </span>
                                            </label>
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
                                            <a href="{{ route('pengurusan.pengajian_sepanjang_hayat.tetapan.penemuduga_sijil_tahfiz.index') }}" class="btn btn-light btn-sm">Batal</a>
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
    if($("#tetapan_peperiksaan_sijil_tahfiz_id").val() != null || $("#tetapan_peperiksaan_sijil_tahfiz_id").val() != '')
    {
        $("#pusat_peperiksaan_id").select2({
            ajax: {
                url: "{{route('pengurusan.pengajian_sepanjang_hayat.tetapan.penemuduga_sijil_tahfiz.fetchPusatPeperiksaan')}}",
                type: "GET",
                data: {
                            siri_id: $("#tetapan_peperiksaan_sijil_tahfiz_id").val(),
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

        $('#ppnegeridiv').hide();
    }

    $("#tetapan_peperiksaan_sijil_tahfiz_id").on('change', function(){
        var tetapan_peperiksaan_sijil_tahfiz_id = this.value;

        $("#pusat_peperiksaan_id").val('');
        $("#pusat_peperiksaan_negeri_id").val('');
        $('#ppnegeridiv').hide();
        $("#pusat_peperiksaan_id").select2({
            ajax: {
                url: "{{route('pengurusan.pengajian_sepanjang_hayat.tetapan.penemuduga_sijil_tahfiz.fetchPusatPeperiksaan')}}",
                type: "GET",
                data: {
                            siri_id: tetapan_peperiksaan_sijil_tahfiz_id,
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
                url: "{{route('pengurusan.pengajian_sepanjang_hayat.tetapan.penemuduga_sijil_tahfiz.fetchPusatPeperiksaan.negeri')}}",
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

</script>

@endpush
