@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <!--begin::Row-->
        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card" id="advanceSearch">
                    <div class="card-header">
                        <h3 class="card-title">{{ $page_title }}</h3>
                    </div>
                    <div class="card-body py-5">
                        <form class="form" action="{{ $action }}" method="post">
                            @if($model->id) @method('PUT') @endif
                            @csrf
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('subjek', 'Subjek', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('subjek', $subjek, $model->subjek_id ?? old('subjek'), ['data-control'=>'select2', 'placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('subjek') ? 'is-invalid':''),'id'=>'subjek' ]) }}
                                        @error('subjek') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_peperiksaan', 'Tarikh Peperiksaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh_peperiksaan',old('tarikh_peperiksaan'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_peperiksaan') ? 'is-invalid':''), 'id' =>'tarikh_peperiksaan','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                        @error('tarikh_peperiksaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('masa_peperiksaan', 'Masa Peperiksaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="time" id="masa_mula" name="masa_peperiksaan" class="form-control form-control-sm">
                                        @error('masa_peperiksaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jumlah_calon', 'Jumlah Calon', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::number('jumlah_calon',$model->jumlah_calon ?? old('jumlah_calon'),['class' => 'form-control form-control-sm '.($errors->has('jumlah_calon') ? 'is-invalid':'')]) }}
                                        @error('jumlah_calon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('lokasi', 'Lokasi', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('lokasi', $lokasi, $model->lokasi_id ?? old('syukbah'), ['data-control'=>'select2', 'placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('lokasi') ? 'is-invalid':''),'id'=>'lokasi' ]) }}
                                        @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        @if(!empty($model->id))
                                        <button type="button" class="btn btn-primary btn-sm me-3">
                                            <i class="fa fa-print" style="vertical-align: initial"></i>Cetak Jadual Peperiksaan
                                        </button>
                                        <a href="{{ route('pengurusan.akademik.peperiksaan.tetapan_peperiksaan.pilih_subjek',$model->id) }}" class="btn btn-dark btn-sm me-3">
                                            <i class="fa fa-plus" style="vertical-align: initial"></i>Pilih Subjek
                                        </a>
                                        @endif
                                        <a href="{{ route('pengurusan.akademik.peperiksaan.tetapan_peperiksaan.index') }}" class="btn btn-sm btn-light">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
    </div>
</div>
@endsection

@push('scripts')
<script>
    const { createApp } = Vue

    createApp({
    data() {
        return {
            show_section_1: true,
            show_section_2: false,
        }
    },
    methods: {
            viewMore(){
                this.show_section_1 = false;
                this.show_section_2 = true;
            },
            hideMore(){
                this.show_section_1 = true;
                this.show_section_2 = false;
            },
        },
    mounted() {

        },
    }).mount('#advanceSearch')
</script>

<script>

    $("#tarikh_peperiksaan").daterangepicker({
        autoApply : true,
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        minYear: parseInt(moment().subtract(1,'y').format("YYYY")),
        maxYear: parseInt(moment().add(4,'y').format("YYYY")),
        locale: {
            format: 'DD/MM/YYYY'
        }
    },function(start, end, label) {
        var datePicked = moment(start).format('DD/MM/YYYY');
        $("#tarikh_peperiksaan").val(datePicked);
    });
    </script>



@endpush
