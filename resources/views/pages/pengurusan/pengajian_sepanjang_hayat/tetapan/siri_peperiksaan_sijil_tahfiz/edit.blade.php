@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <form class="form" action="{{ route('pengurusan.pengajian_sepanjang_hayat.tetapan.sesi_peperiksaan_sijil_tahfiz.update', $id)}}" method="post">
                        @method('PATCH')
                        @csrf
                        <div class="card">
                            <div class="card-body py-5">
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('siri', 'Siri', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('siri',$tetapan->siri,['class' => 'form-control form-control-sm '.($errors->has('siri') ? 'is-invalid':''), 'id' =>'siri','autocomplete' => 'off']) }}
                                            @error('siri') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('lokasi', 'Lokasi Peperiksaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{-- <select name="lokasi[]" class="form-select" data-control="select2" data-placeholder="Sila Pilih" data-allow-clear="true" multiple="multiple" data-hide-search="false">
                                                @foreach ($lokasi_peperiksaan as $lokasi)
                                                    <option value="{{ $lokasi->id }}">{{ $lokasi->nama }}</option>
                                                @endforeach
                                            </select> --}}
                                            <div class="row">
                                            @foreach ($lokasi_peperiksaan as $lokasi)
                                                <div class="col-md-4 mb-2">
                                                    <input class="form-check-input lokasi-checkbox" name="lokasi[]" type="checkbox" value="{{$lokasi->id}}" id="lokasi" @if ($tetapan->lokasi_peperiksaan != NULL && in_array($lokasi->id, json_decode($tetapan->lokasi_peperiksaan))) @checked(true) @endif/>
                                                    <span class="fw-semibold p-2 fs-7 text-capitalize">{{ $lokasi->name }}</span>
                                                </div>
                                            @endforeach
                                            
                                            </div>
                                            @error('lokasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tarikh_permohonan_dibuka', 'Tarikh Permohonan dibuka', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="w-100">
                                            {{ Form::text('tarikh_permohonan_dibuka',date('d/m/Y', strtotime($tetapan->tarikh_permohonan_dibuka)),['class' => 'form-control form-control-sm '.($errors->has('tarikh_permohonan_dibuka') ? 'is-invalid':''), 'id' =>'tarikh_permohonan_dibuka','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            @error('tarikh_permohonan_dibuka') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-1 text-md-center">
                                        {{ Form::label('tarikh_permohonan_ditutup', 'Hingga', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-4">
                                        <div class="w-100">
                                            {{ Form::text('tarikh_permohonan_ditutup',date('d/m/Y', strtotime($tetapan->tarikh_permohonan_ditutup)),['class' => 'form-control form-control-sm '.($errors->has('tarikh_permohonan_ditutup') ? 'is-invalid':''), 'id' =>'tarikh_permohonan_ditutup','onkeydown' =>'return false','autocomplete' => 'off']) }}
                                            @error('tarikh_permohonan_ditutup') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('status', 'Status Permohonan Ujian', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                {{ Form::checkbox('status', $tetapan->status, ($tetapan->status == 0 ? false:true), ['class' => 'form-check-input h-25px w-60px mt-1']); }}
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
                            
                        </div>
                        <div class="card mt-2">
                            <div class="card-body py-5">
                                
                                <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                        <div class="d-flex">
                                            <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                                <i class="fa fa-save" style="vertical-align: initial"></i>Pinda
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
$("#tarikh_permohonan_dibuka").daterangepicker({
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
        $("#tarikh_permohonan_dibuka").val(datePicked);
});
$("#tarikh_permohonan_ditutup").daterangepicker({
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
        $("#tarikh_permohonan_ditutup").val(datePicked);
});

function handleChange(t){
    console.log($('.lokasi-checkbox:checked').val());
}
</script>

@endpush
