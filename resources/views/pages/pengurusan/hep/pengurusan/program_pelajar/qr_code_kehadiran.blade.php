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
                                    {{ Form::label('jenama', 'Nama Program :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <p class="mt-2">{{ $model->nama_program}}</p>
                                    </div>
                                </div>
                            </div>

                            @for ($i = 1; $i <= $model->jumlah_sesi; $i++)
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('jenama', 'QR Code Sesi '.$i.' :', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            @php
                                                $qr_code = SimpleSoftwareIO\QrCode\Facades\QrCode::size(500)->generate(route('kehadiran.submit', [1,2]));
                                            @endphp
                                            {{-- {!! $qr_code !!} --}}
                                            <a class="btn btn-info btn-sm me-3" href="{{ route('pengurusan.hep.pengurusan.program_pelajar.muat_turun_qr_sesi', [$model->id, $i]) }}" target='_blank'> Muat Turun QR Code Sesi {{ $i }}</a>
                                        </div>
                                    </div>
                                </div>
                            @endfor

                            <div class="row mt-5">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <a href="{{ route('pengurusan.hep.pengurusan.program_pelajar.index') }}" class="btn btn-sm btn-light">Kembali</a>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function remove(id){
        Swal.fire({
            title: 'Adakah anda pasti?',
            text: '',
            icon: 'question',
            showCancelButton: true,
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya Padam',
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
                    document.getElementById(`delete-${id}`).submit();
                }
            })
    }
</script>
@endpush
