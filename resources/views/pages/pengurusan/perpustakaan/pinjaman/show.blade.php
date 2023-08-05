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
                        <h3 class="card-title">Maklumat Pinjaman</h3>
                    </div>
                    <div class="card-body py-5">
                        <div class="row fv-row" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('nama', 'Nama Bahan :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="form-control form-control-sm m-0" style="border: none">{{ $pinjaman->bahan->nama }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('isbn', 'ISBN :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="form-control form-control-sm m-0" style="border: none">{{ $pinjaman->bahan->isbn }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('', 'Tarikh Pinjam :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="form-control form-control-sm m-0" style="border: none">{{ Utils::formatDate($pinjaman->tarikh_pinjam) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('', 'Tarikh Pulang :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="form-control form-control-sm m-0" style="border: none">{{ Utils::formatDate($pinjaman->tarikh_pulang) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('', 'Tarikh Pemulangan :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="form-control form-control-sm m-0" style="border: none">{{ $pinjaman->tarikh_pemulangan != NULL ? Utils::formatDate($pinjaman->tarikh_pemulangan) : 'N\A' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('', 'Status Pinjaman :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100 mt-2">
                                    @if ($pinjaman->status == 0)
                                        <span class="badge badge-primary">Belum Dipulangkan</span>
                                    @else
                                        @if ($pinjaman->status_denda == 0)
                                            <span class="badge badge-success">Telah Dipulangkan</span>
                                        @elseif ($pinjaman->status_denda == 1)
                                            <span class="badge badge-danger">Pulang Lewat (Didenda)</span>
                                        @else
                                            <span class="badge badge-success">Pulang Lewat (Selesai Pembayaran Denda)</span>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
                <!--begin::Row-->
                <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                    <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                        <div class="card" id="advanceSearch">
                            <div class="card-header">
                                <h3 class="card-title">Maklumat Peminjam</h3>
                            </div>
                            <div class="card-body py-5">
                                <div class="row fv-row" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('nama', 'Nama', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <p class="form-control form-control-sm m-0" style="border: none">{{ $pinjaman->bahan->nama }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('isbn', 'ISBN', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <p class="form-control form-control-sm m-0" style="border: none">{{ $pinjaman->bahan->isbn }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('lokasi', 'Lokasi', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <p class="form-control form-control-sm m-0" style="border: none">{{ $pinjaman->bahan->lokasi }}</p>
                                        </div>
                                    </div>
                                </div>
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
