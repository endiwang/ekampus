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
                        <div class="row fv-row" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('nama', 'Nama', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="form-control form-control-sm" style="border: none">{{ $model->nama }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('isbn', 'ISBN', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="form-control form-control-sm" style="border: none">{{ $model->isbn }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('lokasi', 'Lokasi', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="form-control form-control-sm" style="border: none">{{ $model->lokasi }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('keahlian_id', 'Peminjam', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    {{ Form::select('keahlian_id', $peminjam, Request::get('keahlian_id'), ['placeholder' => 'Sila Pilih','class' =>'form-select form-select-sm', 'data-control'=>'select2', 'form'=>'pinjam' ]) }}
                                    @error('keahlian_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row mb-2" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('tarikh_pulang', 'Tarikh Pemulangan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    {{ Form::text('tarikh_pulang', old('tarikh_pulang'),['class' => 'form-control form-control-sm '.($errors->has('tarikh_pulang') ? 'is-invalid':''), 'id' =>'tarikh_pulang','onkeydown' =>'return true','autocomplete' => 'off', 'form'=>'pinjam']) }}
                                    @error('tarikh_pulang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                        <form class="form" action="{{ route('pengurusan.perpustakaan.bahan.pinjam')}}" method="post" id="pinjam">
                            {!! Form::hidden('bahan_id', $model->id, ['class' => '']) !!}
                            @csrf

                        <div class="row">
                            <div class="col-md-9 offset-md-3">
                                <div class="d-flex">
                                    <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                        <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                    </button>
                                    <a href="{{ route('pengurusan.perpustakaan.bahan.index') }}" class="btn btn-sm btn-light">Batal</a>
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
    $("#tarikh_pulang").daterangepicker({
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
        $("#tarikh_pulang").val(datePicked);
    });
</script>




@endpush
