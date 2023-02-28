@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">

            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="card bg-transparent">
                        <div class="card-body bg-transparent py-5">
                            @if($data->kursus_id == 1)
                                {{-- Diploma --}}
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.default.maklumat_pemohon')
                                <br>
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.default.maklumat_ibu_bapa_penjaga')
                                <br>
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.default.tempat_temuduga')
                                <br>
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.default.akuan_bank')
                                <br>
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.default.dokumen')
                                <br>
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.diploma.kelulusan_akademik')
                                <br>
                            @elseif ($data->kursus_id == 23)
                                {{-- Sijil Asas Tahfiz --}}
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.default.maklumat_pemohon')
                                <br>
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.default.maklumat_ibu_bapa_penjaga')
                                <br>
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.default.tempat_temuduga')
                                <br>
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.default.akuan_bank')
                                <br>
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.default.dokumen')
                                <br>

                            @elseif ($data->kursus_id == 25)
                                {{-- Sijil Kemahiran Malaysia Pengurusan Masjid--}}
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.default.maklumat_pemohon')
                                <br>
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.default.maklumat_ibu_bapa_penjaga')
                                <br>
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.default.tempat_temuduga')
                                <br>
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.default.akuan_bank')
                                <br>
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.default.dokumen')
                                <br>


                            @else
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.default.maklumat_pemohon')
                                <br>
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.default.maklumat_ibu_bapa_penjaga')
                                <br>
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.default.tempat_temuduga')
                                <br>
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.default.akuan_bank')
                                <br>
                                @include('pages.pengurusan.kbg.senarai_permohonan.borang.default.dokumen')
                                <br>



                            @endif
                            <div class="d-flex justify-content-center">
                                <!--begin::Button-->
                                <a href="../../demo1/dist/apps/ecommerce/catalog/products.html" id="kt_ecommerce_add_product_cancel" class="btn btn-success me-5">Simpan</a>
                                <a href="../../demo1/dist/apps/ecommerce/catalog/products.html" id="kt_ecommerce_add_product_cancel" class="btn btn-info me-5">Cetak Borang</a>
                                <button onclick="pilih()" id="kt_ecommerce_add_product_cancel" class="btn btn-primary me-5">Proses Pemilihan</button>
                                <form id="pilih" action="{{ route('pengurusan.kbg.pengurusan.senarai_permohonan.pilih') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $data->id }}">
                                </form>
                                <a href="../../demo1/dist/apps/ecommerce/catalog/products.html" id="kt_ecommerce_add_product_cancel" class="btn btn-light me-5">Kembali</a>
                                <!--end::Button-->
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
        $("#tarikh_lahir").daterangepicker({
        autoApply : true,
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        minYear: parseInt(moment().subtract(30,'y').format("YYYY")),
        maxYear: parseInt(moment().format("YYYY")),
        locale: {
            format: 'DD/MM/YYYY'
        }
    },function(start, end, label) {
        var datePicked = moment(start).format('DD/MM/YYYY');
        $("#tarikh_lahir").val(datePicked);
    });
</script>
    <script>
        function pilih(){
            Swal.fire({
                icon:'question',
                title: 'Adakah anda pasti?',
                showCancelButton: true,
                cancelButtonText: 'Tidak',
                confirmButtonText: 'Ya, Pilih Calon Ini',
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
                        document.getElementById(`pilih`).submit();
                    }
                })
        }
    </script>

@endpush
