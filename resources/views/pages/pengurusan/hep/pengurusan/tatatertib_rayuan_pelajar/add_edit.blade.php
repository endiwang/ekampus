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
                        <h3 class="card-title">Dokumentasi Tatatertib Pelajar</h3>
                    </div>
                    <div class="card-body py-5">
                        <form class="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                            @if($model->id) @method('PUT') @endif
                            @csrf

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('pelajar_id', 'Pelajar', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('pelajar_id', $pelajar, $model->pelajar_id ?? old('pelajar_id'), ['placeholder' => 'Sila Pilih','class' =>'form-select form-select-sm ', 'data-control'=>'select2', 'required' => 'required', $model->id ? 'disabled' : '' ]) }}
                                        @error('pelajar_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('laporan_kes_upload', 'Laporan Kes', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="file" class="form-control form-control-sm" name="laporan_kes_upload" id="laporan_kes_upload" required>
                                        @error('laporan_kes_upload') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nota_hadir_upload', 'Nota Hadir', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="file" class="form-control form-control-sm" name="nota_hadir_upload" id="nota_hadir_upload" required>
                                        @error('nota_hadir_upload') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('fakta_kes_upload', 'Fakta Kes', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="file" class="form-control form-control-sm" name="fakta_kes_upload" id="fakta_kes_upload" required>
                                        @error('fakta_kes_upload') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kertas_pertuduhan_upload', 'Kertas Pertuduhan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="file" class="form-control form-control-sm" name="kertas_pertuduhan_upload" id="kertas_pertuduhan_upload" required>
                                        @error('kertas_pertuduhan_upload') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('keputusan_kes_hukuman', 'Keputusan Kes', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('keputusan_kes_hukuman',$model->keputusan_kes_hukuman ?? old('keputusan_kes_hukuman'),['class' => 'form-control form-control-sm '.($errors->has('keputusan_kes_hukuman') ? 'is-invalid':''), 'id' =>'keputusan_kes_hukuman', 'rows'=>'3']) }}
                                        @error('keputusan_kes_hukuman') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nota_prosiding', 'Nota Prosiding', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('nota_prosiding',$model->nota_prosiding ?? old('nota_prosiding'),['class' => 'form-control form-control-sm '.($errors->has('nota_prosiding') ? 'is-invalid':''), 'id' =>'nota_prosiding', 'rows'=>'3']) }}
                                        @error('nota_prosiding') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status_hukuman', 'Status Hukuman', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('status_hukuman', ['0' => 'Belum Berjalan', '1' => 'Sedang Berjalan', '2' => 'Selesai'], $model->status_hukuman ?? old('status_hukuman'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm ', 'data-control'=>'select2', 'required' => 'required' ]) }}
                                        @error('status_hukuman') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            {{-- @if($model->aduan_salahlaku_pelajar_id)
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('aduan', 'Aduan (jika ada)', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <a href="{{ route('pengurusan.hep.pengurusan.salahlaku_pelajar.edit', $model->aduan_salahlaku_pelajar_id) }}" target="_blank" id="kt_share_earn_link_copy_button" class="btn btn-info btn-sm fw-bold flex-shrink-0">
                                            <i class="fa fa-file" style="vertical-align: initial"></i>Aduan
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @if($model->siasatan_aduan_salahlaku_pelajar_id)
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('siasatan', 'Siasatan (jika ada)', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <a href="{{ route('pengurusan.hep.pengurusan.salahlaku_pelajar.siasatan', $model->siasatan_aduan_salahlaku_pelajar_id) }}" target="_blank" id="kt_share_earn_link_copy_button" class="btn btn-info btn-sm fw-bold flex-shrink-0">
                                            <i class="fa fa-file" style="vertical-align: initial"></i>Siasatan
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif --}}
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pengurusan.hep.pengurusan.disiplin_pelajar.index') }}" class="btn btn-sm btn-light">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    $("#tarikh_masuk").daterangepicker({
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
            $("#tarikh_masuk").val(datePicked);
    });

    $("#tarikh_keluar").daterangepicker({
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
            $("#tarikh_keluar").val(datePicked);
    });
    </script>


@endpush
