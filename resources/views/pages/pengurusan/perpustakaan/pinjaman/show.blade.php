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
                        <div class="row fv-row" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('isbn', 'Denda :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="form-control form-control-sm m-0" style="border: none">{{ $pinjaman->denda > 0 ? 'RM '.$pinjaman->denda : 'Tiada' }}</p>
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
                                {{ Form::label('nama', 'Nama :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="form-control form-control-sm m-0" style="border: none">{{ $pinjaman->ahli->nama }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('isbn', 'No Ic :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="form-control form-control-sm m-0" style="border: none">{{ $pinjaman->ahli->ic_no }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('lokasi', 'No Telefon :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100">
                                    <p class="form-control form-control-sm m-0" style="border: none">{{ $pinjaman->ahli->no_telefon }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row fv-row" >
                            <div class="col-md-3 text-md-end">
                                {{ Form::label('lokasi', 'Kategori :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                            </div>
                            <div class="col-md-9">
                                <div class="w-100 mt-2">
                                    @if($pinjaman->ahli->is_public == 1)
                                    <span class="badge badge-success">Orang Awam</span>
                                    @elseif ($pinjaman->ahli->is_staff == 1)
                                    <span class="badge badge-success">Kakitangan</span>
                                    @elseif ($pinjaman->ahli->is_pelajar == 1)
                                    <span class="badge badge-success">Pelajar</span>
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
                    <div class="card-body py-5">
                        <div class="row">
                            <div class="col-md-9 offset-md-3">
                                <div class="d-flex">
                                    @if ($pinjaman->status == 0)
                                    <button type="button" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3" onclick="pulang()">
                                        <i class="fa fa-book" style="vertical-align: initial"></i>Pulang Bahan Pinjaman
                                    </button>
                                    @else
                                        @if ($pinjaman->status_denda == 1)
                                        <button type="button" class="btn btn-danger btn-sm me-3" onclick="bayar()">
                                            <i class="fa fa-dollar" style="vertical-align: initial"></i>Selesai Bayar Denda
                                        </button>
                                        @endif
                                    @endif
                                    <a href="{{ URL::previous() }}" class="btn btn-sm btn-light">Kembali</a>
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
    function pulang(id){
        Swal.fire({
            title: 'Adakah anda pasti?',
            text: '',
            icon: 'question',
            showCancelButton: true,
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya, Pulang Bahan Pinjaman',
            reverseButtons: true,
            customClass: {
                title: 'swal-modal-delete-title',
                htmlContainer: 'swal-modal-delete-container',
                cancelButton: 'btn btn-light btn-sm mr-1',
                confirmButton: 'btn btn-primary btn-sm ml-1'
            },
            buttonsStyling: false
        })
            .then((result) => {
                if(result.isConfirmed){
                        $.ajax({
                        url: '{{route('pengurusan.perpustakaan.pinjaman.pulang')}}',
                        type: 'post',
                        data: {
                                    id: '{{ $pinjaman->id }}',
                                    _token: '{{csrf_token()}}'
                                },
                        dataType: 'json',
                        success: function(data){
                        location.reload();
                        }
                    });

                }
            })
    }
    function bayar(id){
        Swal.fire({
            title: 'Adakah anda pasti?',
            text: '',
            icon: 'question',
            showCancelButton: true,
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya, Selesai Pembayaran Denda',
            reverseButtons: true,
            customClass: {
                title: 'swal-modal-delete-title',
                htmlContainer: 'swal-modal-delete-container',
                cancelButton: 'btn btn-light btn-sm mr-1',
                confirmButton: 'btn btn-primary btn-sm ml-1'
            },
            buttonsStyling: false
        })
        .then((result) => {
                if(result.isConfirmed){
                        $.ajax({
                        url: '{{route('pengurusan.perpustakaan.pinjaman.bayar_denda')}}',
                        type: 'post',
                        data: {
                                    id: '{{ $pinjaman->id }}',
                                    _token: '{{csrf_token()}}'
                                },
                        dataType: 'json',
                        success: function(data){
                        location.reload();
                        }
                    });

                }
            })
    }
</script>

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
