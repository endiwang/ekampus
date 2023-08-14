@extends('layouts.public.main_inner_pemohon')
@section('content')
    <div class="py-10 py-lg-20">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                <!--begin::Row-->
                <div class="row g-5 g-xl-12">
                    <div class="col-xl-12">
                        <!--begin::Table widget 14-->
                        <div class="card">
                            <!--begin::Header-->
                            <!--end::Header-->
                            <!--begin::Body-->
                            <div class="card-body pt-6">
                                <div class="fs-2 fw-bold text-gray-800 text-center mb-13">
                                    <span class="me-2">Tahniah!! </span> <br>
                                    <span class="me-2">Anda terpilih untuk mengikuti program : </span> <br>
                                    <span class="position-relative d-inline-block text-danger">
                                        <span class="text-danger opacity-75-hover">{{ $permohonan->kursus->nama }}</span>
                                        <!--begin::Separator-->
                                        <span class="position-absolute opacity-15 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span>
                                        <!--end::Separator-->
                                    </span><br>
                                    <span class="me-2">Bagi sesi : </span> <br>
                                    <span class="position-relative d-inline-block text-danger">
                                        <span class="text-danger opacity-75-hover">{{ $permohonan->sesi->nama }}</span>
                                        <!--begin::Separator-->
                                        <span class="position-absolute opacity-15 bottom-0 start-0 border-4 border-danger border-bottom w-100"></span>
                                        <!--end::Separator-->
                                    </span>
                                </div>

                                <div class="text-center mb-1">
                                    <!--begin::Link-->
                                    <button onclick="terima()" class="btn btn-primary me-2">Terima Tawaran</button>

                                    <!--end::Link-->
                                    <!--begin::Link-->
                                    <button onclick="tolak()" class="btn btn-danger">Tolak Tawaran</button>
                                    <!--end::Link-->
                                </div>
                            </div>
                            <form id="terima" action="{{ route('pemohon.tawaran.keputusan.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $permohonan->id }}">
                                <input type="hidden" name="is_terima" value="1">
                            </form>
                            <form id="tolak" action="{{ route('pemohon.tawaran.keputusan.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $permohonan->id }}">
                                <input type="hidden" name="is_terima" value="2">
                            </form>

                            <!--end: Card Body-->
                        </div>
                        <!--end::Table widget 14-->
                    </div>
                </div>
                <!--end::Row-->
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>
    function terima(){
        Swal.fire({
            icon:'question',
            title: 'Adakah anda pasti untuk terima tawaran ini?',
            showCancelButton: true,
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya, TERIMA Tawaran',
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
                    document.getElementById(`terima`).submit();
                }
            })
    }

    function tolak(){
        Swal.fire({
            icon:'question',
            title: 'Adakah anda pasti untuk tolak tawaran ini?',
            showCancelButton: true,
            cancelButtonText: 'Tidak',
            confirmButtonText: 'Ya, TOLAK Tawaran',
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
                    document.getElementById(`tolak`).submit();
                }
            })
    }
</script>
@endsection
