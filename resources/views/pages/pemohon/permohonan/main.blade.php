@extends('layouts.public.main_inner_pemohon')
@section('content')

<div class="py-10 py-lg-20">
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Card-->
            <div class="card">
                <!--begin::Card body-->
                <div class="card-header">
                    <h3 class="card-title">Permohonan Kursus : {{ $kursus->nama }}</h3>
                </div>
                <div class="card-body">
                    <!--begin::Stepper-->
                    <div class="stepper stepper-pills" id="permohonan">
                        <!--begin::Nav-->
                        <div class="stepper-nav flex-center flex-wrap mb-10">
                            <!--begin::Step 1-->
                            <div class="stepper-item mx-8 my-4 current" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">A</span>
                                    </div>
                                    <!--end::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Bahagian A
                                        </h3>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 1-->

                            {{-- <!--begin::Step 2-->
                            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">B</span>
                                    </div>
                                    <!--begin::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Bahagian B
                                        </h3>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 2--> --}}

                            <!--begin::Step 3-->
                            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">B</span>
                                    </div>
                                    <!--begin::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Bahagian B
                                        </h3>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 3-->

                            <!--begin::Step 4-->
                            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">C</span>
                                    </div>
                                    <!--begin::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Bahagian C
                                        </h3>
                                    </div>
                                    <!--end::Label-->
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 4-->
                            <!--begin::Step 4-->
                            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">D</span>
                                    </div>
                                    <!--begin::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Bahagian D
                                        </h3>
                                    </div>
                                    <!--end::Label-->

                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 4-->
                            <!--begin::Step 4-->
                            <div class="stepper-item mx-8 my-4" data-kt-stepper-element="nav">
                                <!--begin::Wrapper-->
                                <div class="stepper-wrapper d-flex align-items-center">
                                    <!--begin::Icon-->
                                    <div class="stepper-icon w-40px h-40px">
                                        <i class="stepper-check fas fa-check"></i>
                                        <span class="stepper-number">E</span>
                                    </div>
                                    <!--begin::Icon-->

                                    <!--begin::Label-->
                                    <div class="stepper-label">
                                        <h3 class="stepper-title">
                                            Bahagian E
                                        </h3>
                                    </div>
                                    <!--end::Label-->

                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Line-->
                                <div class="stepper-line h-40px"></div>
                                <!--end::Line-->
                            </div>
                            <!--end::Step 4-->
                        </div>
                        <!--end::Nav-->

                        <!--begin::Form-->
                        <form class="form mx-auto" novalidate="novalidate" id="borang_permohonan" method="post" action="{{ route('pemohon.permohonan.store') }}" enctype="multipart/form-data">
                            @csrf
                            <!--begin::Group-->
                            <div class="mb-5">

                                <!--Bahagian A : Start-->
                                <div class="flex-column current" data-kt-stepper-element="content">
                                    @include('pages.pemohon.permohonan.borang.a_maklumat_pemohon')
                                </div>
                                <!--Bahagian A : End-->
                                <!--Bahagian B : Start-->
                                {{-- <div class="flex-column" data-kt-stepper-element="content">
                                    @include('pages.pemohon.permohonan.borang.b_tempat_temuduga')
                                </div> --}}
                                <!--Bahagian B : End-->
                                <!--Bahagian C : Start-->
                                <div class="flex-column" data-kt-stepper-element="content">
                                    @include('pages.pemohon.permohonan.borang.c_maklumat_ibu_bapa_penjaga')
                                </div>
                                <!--Bahagian C : End-->
                                <!--Bahagian D : Start-->
                                <div class="flex-column" data-kt-stepper-element="content">
                                    @include('pages.pemohon.permohonan.borang.d_kelulusan_akademik')
                                </div>
                                <!--Bahagian D : End-->
                                <!--Bahagian E : Start-->
                                <div class="flex-column" data-kt-stepper-element="content">
                                    @include('pages.pemohon.permohonan.borang.e_muatnaik_dokumen')
                                </div>
                                <!--Bahagian E : End-->
                                <!--Bahagian F : Start-->
                                <div class="flex-column" data-kt-stepper-element="content">
                                    @include('pages.pemohon.permohonan.borang.f_perakuan_pemohon')
                                </div>
                                <!--Bahagian F : End-->



                            </div>
                            <!--end::Group-->

                            <!--begin::Actions-->
                            <div class="d-flex flex-stack">
                                <!--begin::Wrapper-->
                                <div class="me-2">
                                    <button type="button" class="btn btn-light btn-active-light-primary" data-kt-stepper-action="previous">
                                        Kembali
                                    </button>
                                </div>
                                <!--end::Wrapper-->

                                <!--begin::Wrapper-->
                                <div>
                                    <button type="button" class="btn btn-primary" data-kt-stepper-action="submit">
                                        <span class="indicator-label">
                                            Hantar
                                        </span>
                                        <span class="indicator-progress">
                                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                    </button>

                                    <button type="button" class="btn btn-primary" data-kt-stepper-action="next">
                                        Simpan dan Teruskan
                                    </button>
                                </div>
                                <!--end::Wrapper-->
                            </div>
                            <!--end::Actions-->
                        </form>
                        <!--end::Form-->
                    </div>
                    <!--end::Stepper-->

                </div>
                <!--end::Card body-->
            </div>
            <!--end::Card-->
        </div>
        <!--end::Content container-->
    </div>
</div>

@endsection
@section('script')
<script>

    var bahagianC = '';
    var bahagianD = '';
    const form = document.querySelector("#permohonan");
    const submit_button = form.querySelector('[data-kt-stepper-action="submit"]');
    const formBahagianA = document.querySelector("#formPermohonanA");
    const formBahagianB = document.querySelector("#formPermohonanB");
    const formBahagianC = document.querySelector("#formPermohonanE");
    const formBahagianD = document.querySelector("#formPermohonanC");
    const formBahagianE = document.querySelector("#formPermohonanF");
    const formBahagianF = document.querySelector("#formPermohonanG");

    const namaValidators = {
                    validators: {
                        notEmpty: {
                            message: 'Sila masukkan nama',
                        },
                    },
                };
    const institusiValidators = {
                    validators: {
                        notEmpty: {
                            message: 'Sila masukkan institusi',
                        },
                    },
                };
    const umurValidators = {
                    validators: {
                        notEmpty: {
                            message: 'Sila masukkan umur',
                        },
                    },
                };
    const namaSijilSetarafValidators = {
                    validators: {
                        notEmpty: {
                            message: 'Sila masukkan nama subjek',
                        },
                    },
                };
    const gredSijilSetarafValidators = {
                    validators: {
                        notEmpty: {
                            message: 'Sila masukkan gred subjek',
                        },
                    },
                };

    const { createApp } = Vue

    const formC = createApp(
        {
            data() {
                return {
                    sijil_lain: [
                    ],
                    stam: [
                    ],
                    showResultSPM : 0,
                    showResultSetara : 0,
                }
            },
            methods: {
                addRowSijilLain(){
                    this.sijil_lain.push(
                        {
                            nama_subject_sijil_tambahan: '',
                            gred: ''
                        });
                },
                removeRowSijilLain(index){
                    this.sijil_lain.splice(index,1)
                },
                addRowSTAM(){
                    this.stam.push(
                        {
                            nama_subject_stam: '',
                            gred: ''
                        });
                },
                removeRowSTAM(index){
                    this.stam.splice(index,1)
                },
                jenisPeperiksaan(e){
                    if(e.target.value == 'spm')
                    {
                        this.showResultSPM = 1;
                        this.showResultSetara = 0;

                    }else if(e.target.value == 'setara')
                    {
                        this.showResultSetara = 1;
                        this.showResultSPM = 0;

                    }else{
                        this.showResultSetara = 0;
                        this.showResultSPM = 0;
                    }
                }
            }
        }
    ).mount('#formPermohonanC')

    const formD = createApp(
        {
            data() {
                return {
                    pendidikan_menengah : [
                    ],
                    aktiviti_persatuan : [
                    ]

                }
            },
            methods: {
                addRowPendidikanMenengah(){
                    this.pendidikan_menengah.push(
                        {
                            nama_sekolah: '',
                            tahun: '',
                            keputusan_tetinggi: '',
                        });
                },
                removeRowPendidikanMenengah(index){
                    this.pendidikan_menengah.splice(index,1)
                },
                addRowAktivitiPersatuan(){
                    this.aktiviti_persatuan.push(
                        {
                            tahun: '',
                            persatuan: '',
                            jawatan: '',
                        });
                },
                removeRowAktivitiPersatuan(index){
                    this.aktiviti_persatuan.splice(index,1)
                }
            }
        }
    ).mount('#formPermohonanD')

    const formE= createApp(
        {
            data() {
                return {
                    showMaklumatBapa : 0,
                    showMaklumatIbu : 0,
                    showMaklumatPenjaga : 0,
                    addedRowIndex : '',
                }
            },
            methods: {
                maklumatBapa(e)
                {
                    if(e.target.value == 'masih_hidup')
                    {
                        this.showMaklumatBapa = 1;
                    }else{
                        this.showMaklumatBapa = 0;
                    }
                },
                maklumatIbu(e)
                {
                    if(e.target.value == 'masih_hidup')
                    {
                        this.showMaklumatIbu = 1;
                    }else{
                        this.showMaklumatIbu = 0;
                    }
                },
                maklumatPenjaga(e)
                {
                    if(e.target.value == 'penjaga')
                    {
                        this.showMaklumatPenjaga = 1;
                    }else{
                        this.showMaklumatPenjaga = 0;
                    }
                },
            },
        }
    ).mount('#formPermohonanE')


    @include('pages.pemohon.permohonan.borang.form_validation');

    var stepper = new KTStepper(form);

    // Handle next step
    stepper.on("kt.stepper.next", function (stepper) {
            var step_validation = step[stepper.getCurrentStepIndex() - 1];
            var form_permohonan = $('#borang_permohonan')[0];
            var form_data = new FormData(form_permohonan);

            if($('input[name=mykad_passport]')[0].files[0])
            {
                form_data.append('mykad_passport', $('input[name=mykad_passport]')[0].files[0]);
            }

            if($('input[name=sijil_spm_setara]')[0].files[0])
            {
                form_data.append('sijil_spm_setara', $('input[name=sijil_spm_setara]')[0].files[0]);
            }

            if($('input[name=kad_oku]')[0].files[0])
            {
                form_data.append('kad_oku', $('input[name=kad_oku]')[0].files[0]);
            }


            // form_data.append("file", document.getElementById('avatar').files[0]);
            // form_data.append("nama_pemohon", $("#nama_pemohon").val());
            // console.log(form_data.entries());

            // if(stepper.getCurrentStepIndex() == 4)
            // {
            //     var count_checkbox = 0;
            //     $("[name^=pilih_pusat_pengajian_]").each(function() {
            //         if(this.checked){
            //             count_checkbox++;
            //         }
            //     })
            //     if(count_checkbox < 1)
            //     {
            //         stepper.goPrevious();
            //         Swal.fire({
            //                 title: "Maklumat Tidak Lengkap",
            //                 text: "Maaf, sila pilih sekurang-kurangnya satu pusat pengajian",
            //                 icon: "error",
            //                 buttonsStyling: !1,
            //                 confirmButtonText: "Baik",
            //                 customClass: { confirmButton: "btn btn-light" },
            //                 }).then(function () {
            //                 KTUtil.scrollTop();
            //                 });
            //     }
            // }
            step_validation
                ? step_validation.validate().then(function (t)
                    {
                        "Valid" == t
                        ? (
                            $.ajax({
                                url: "{!! route('pemohon.permohonan.simpan_dan_seterusnya')!!}",
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

                                type: "POST",
                                processData: false,
                                contentType: false,
                                data: form_data,
                                dataType: 'json',
                                success: function(data){
                                    console.log('ok');
                                }
                            }),
                            stepper.goNext(),
                            KTUtil.scrollTop())
                        : Swal.fire({
                            title: "Maklumat Tidak Lengkap",
                            text: "Maaf, maklumat yang anda isi tidak lengkap, sila semak kotak bertanda merah.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Baik",
                            customClass: { confirmButton: "btn btn-light" },
                            }).then(function () {
                            KTUtil.scrollTop();
                            });
                    })
                : (
                    $.ajax({
                                url: "{!! route('pemohon.permohonan.simpan_dan_seterusnya')!!}",
                                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},

                                type: "POST",
                                processData: false,
                                contentType: false,
                                data: form_data,
                                dataType: 'json',
                                success: function(data){
                                    console.log('ok');
                                }
                            }),
                            stepper.goNext(),
                            KTUtil.scrollTop()
                );

    });

    // Handle previous step
    stepper.on("kt.stepper.previous", function (stepper) {
        stepper.goPrevious(); // go previous step
    });
    // Handle submit button
    submit_button.addEventListener("click", function (stepper) {
        var step_validation = step[4];
        let isChecked = $('#perakuan_pemohon').prop('checked');
        var step_validation_final = step[4];



        var count_checkbox = 0;
        $("[name^=pilih_pusat_pengajian]").each(function() {
            if(this.checked){
                count_checkbox++;
            }
        })
        if(count_checkbox < 1)
        {
            // stepper.goPrevious();
            Swal.fire({
                    title: "Maklumat Tidak Lengkap",
                    text: "Maaf, sila pilih sekurang-kurangnya satu pusat pengajian",
                    icon: "error",
                    buttonsStyling: !1,
                    confirmButtonText: "Baik",
                    customClass: { confirmButton: "btn btn-light" },
                    }).then(function () {
                    KTUtil.scrollTop();
                    });
        }else{


            step_validation.validate().then(function (t)
                    {
                        if( "Valid" != t)
                        {
                            Swal.fire({
                            title: "Maklumat Tidak Lengkap",
                            text: "Maaf, maklumat yang anda isi tidak lengkap, sila semak kotak bertanda merah.",
                            icon: "error",
                            buttonsStyling: !1,
                            confirmButtonText: "Baik",
                            customClass: { confirmButton: "btn btn-light" },
                            }).then(function () {
                            KTUtil.scrollTop();
                            });
                        }else{

                            if(isChecked)
                            {
                                $("#borang_permohonan").submit()
                            }else{
                            Swal.fire({
                                    title: "Maklumat Tidak Lengkap",
                                    text: "Maaf, sila tanda kotak perakuan untuk menghantar permohonan",
                                    icon: "error",
                                    buttonsStyling: !1,
                                    confirmButtonText: "Baik",
                                    customClass: { confirmButton: "btn btn-light" },
                                    }).then(function () {
                                    KTUtil.scrollTop();
                                    });
                            }

                        }

                    });
        }




    });

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

    $("#status_bapa").change(function () {
        if(this.value == 'masih_hidup')
        {

            bahagianC.enableValidator('ic_no_bapa', 'notEmpty');
            bahagianC.enableValidator('alamat_bapa','notEmpty');
            bahagianC.enableValidator('poskod_bapa','notEmpty');
            bahagianC.enableValidator('no_telefon_bapa','notEmpty');
            bahagianC.enableValidator('status_pekerjaan_bapa','notEmpty');
            bahagianC.enableValidator('jenis_pekerjaan_bapa','notEmpty');
            bahagianC.enableValidator('pendapatan_bapa','notEmpty');

        }else{
            bahagianC.disableValidator('ic_no_bapa', 'notEmpty');
            bahagianC.disableValidator('alamat_bapa','notEmpty');
            bahagianC.disableValidator('poskod_bapa','notEmpty');
            bahagianC.disableValidator('no_telefon_bapa','notEmpty');
            bahagianC.disableValidator('status_pekerjaan_bapa','notEmpty');
            bahagianC.disableValidator('jenis_pekerjaan_bapa','notEmpty');
            bahagianC.disableValidator('pendapatan_bapa','notEmpty');
        }

    });

    $("#jenis_peperiksaan").change(function () {
        if(this.value == 'setara')
        {
            bahagianD.enableValidator('sijil_lain', 'notEmpty');
            bahagianD.enableValidator('nama_peperiksaan_sijil_lain','notEmpty');
            bahagianD.enableValidator('subjek_nama[0]', 'notEmpty');
            bahagianD.enableValidator('subjek_gred[0]','notEmpty');

        }else{
            bahagianD.disableValidator('sijil_lain', 'notEmpty');
            bahagianD.disableValidator('nama_peperiksaan_sijil_lain','notEmpty');
            bahagianD.disableValidator('subjek_nama[0]', 'notEmpty');
            bahagianD.disableValidator('subjek_gred[0].gred','notEmpty');
        }

    });

    $("#status_ibu").change(function () {
        if(this.value == 'masih_hidup')
        {
            bahagianC.enableValidator('ic_no_ibu', 'notEmpty');
            bahagianC.enableValidator('alamat_ibu','notEmpty');
            bahagianC.enableValidator('poskod_ibu','notEmpty');
            bahagianC.enableValidator('no_telefon_ibu','notEmpty');
            bahagianC.enableValidator('status_pekerjaan_ibu','notEmpty');
            bahagianC.enableValidator('jenis_pekerjaan_ibu','notEmpty');
            bahagianC.enableValidator('pendapatan_ibu','notEmpty');

        }else{
            bahagianC.disableValidator('ic_no_ibu', 'notEmpty');
            bahagianC.disableValidator('alamat_ibu','notEmpty');
            bahagianC.disableValidator('poskod_ibu','notEmpty');
            bahagianC.disableValidator('no_telefon_ibu','notEmpty');
            bahagianC.disableValidator('status_pekerjaan_ibu','notEmpty');
            bahagianC.disableValidator('jenis_pekerjaan_ibu','notEmpty');
            bahagianC.disableValidator('pendapatan_ibu','notEmpty');
        }
    });

    $("#pemohon_tinggal_bersama").change(function () {
        if(this.value == 'penjaga')
        {
            bahagianC.enableValidator('nama_penjaga', 'notEmpty');
            bahagianC.enableValidator('ic_no_penjaga', 'notEmpty');
            bahagianC.enableValidator('alamat_penjaga','notEmpty');
            bahagianC.enableValidator('poskod_penjaga','notEmpty');
            bahagianC.enableValidator('no_telefon_penjaga','notEmpty');
            bahagianC.enableValidator('status_pekerjaan_penjaga','notEmpty');
            bahagianC.enableValidator('jenis_pekerjaan_penjaga','notEmpty');
            bahagianC.enableValidator('pendapatan_penjaga','notEmpty');
            bahagianC.enableValidator('pertalian_penjaga','notEmpty');

        }else{
            bahagianC.disableValidator('nama_penjaga', 'notEmpty');
            bahagianC.disableValidator('ic_no_penjaga', 'notEmpty');
            bahagianC.disableValidator('alamat_penjaga','notEmpty');
            bahagianC.disableValidator('poskod_penjaga','notEmpty');
            bahagianC.disableValidator('no_telefon_penjaga','notEmpty');
            bahagianC.disableValidator('status_pekerjaan_penjaga','notEmpty');
            bahagianC.disableValidator('jenis_pekerjaan_penjaga','notEmpty');
            bahagianC.disableValidator('pendapatan_penjaga','notEmpty');
            bahagianC.disableValidator('pertalian_penjaga','notEmpty');
        }
    });

    $("#jenis_peperiksaan").change(function () {
        if(this.value == 'spm')
        {
            @foreach ($subjek_spm as $subjek)
                bahagianD.enableValidator('{!! $subjek->slug !!}', 'notEmpty');
            @endforeach
        }else{
            @foreach ($subjek_spm as $subjek)
                bahagianD.disableValidator('{!! $subjek->slug !!}', 'notEmpty');
            @endforeach
        }
    });

    const removeRow = function (rowIndex) {
        const row = formBahagianC.querySelector('[data-row-index="' + rowIndex + '"]');
        bahagianC.removeField('tanggungan_nama[' + rowIndex + ']')
                .removeField('tanggungan_institusi[' + rowIndex + ']')
                .removeField('tanggungan_umur[' + rowIndex + ']');
        row.parentNode.removeChild(row);
    };


    const template = document.getElementById('template');
    let rowIndex = -1;
    document.getElementById('addButton').addEventListener('click', function () {
        rowIndex++;

        const clone = template.cloneNode(true);
        clone.removeAttribute('id');

        clone.style.display = 'flex';

        clone.setAttribute('data-row-index', rowIndex);

        template.before(clone);

        let nama_tanggungan = clone.querySelector('[data-name="tanggungan.nama"]');
        let institusi_tanggungan = clone.querySelector('[data-name="tanggungan.institusi"]');
        let umur_tanggungan = clone.querySelector('[data-name="tanggungan.umur"]');

        nama_tanggungan.setAttribute('name', 'tanggungan_nama[' + rowIndex + ']');
        // nama_tanggungan.setAttribute('name', 'tanggungan[' + rowIndex + '].nama');
        nama_tanggungan.value = '';

        institusi_tanggungan.setAttribute('name', 'tanggungan_institusi[' + rowIndex + ']');
        // institusi_tanggungan.setAttribute('name', 'tanggungan[' + rowIndex + '].institusi');
        institusi_tanggungan.value = '';

        umur_tanggungan.setAttribute('name', 'tanggungan_umur[' + rowIndex + ']');
        // umur_tanggungan.setAttribute('name', 'tanggungan[' + rowIndex + '].umur');
        umur_tanggungan.value = '';

        let button_remove = clone.querySelector('.js-remove-button');
        let button_remove_icon = clone.querySelector('.js-remove-button-icon');

        button_remove.setAttribute('data-row-index', rowIndex);
        button_remove_icon.setAttribute('data-row-index', rowIndex);

        button_remove.addEventListener('click', function (e) {
            const index = e.target.getAttribute('data-row-index');
            removeRow(index);
        });
        button_remove_icon.addEventListener('click', function (e) {
            const index = e.target.getAttribute('data-row-index');
            removeRow(index);
        });

        // bahagianC.addField('tanggungan[' + rowIndex + '].nama', namaValidators)
        //         .addField('tanggungan[' + rowIndex + '].institusi', institusiValidators)
        //         .addField('tanggungan[' + rowIndex + '].umur', umurValidators);
        bahagianC.addField('tanggungan_nama[' + rowIndex + ']', namaValidators)
                .addField('tanggungan_institusi[' + rowIndex + ']', institusiValidators)
                .addField('tanggungan_umur[' + rowIndex + ']', umurValidators);
    });


    // Bahagian D Sijil Setaraf

    const removeRowSijilSetaraf = function (rowIndexSijilSetaraf) {
        const rowSijilSetaraf = formBahagianD.querySelector('[data-row-index-sijil-setaraf="' + rowIndexSijilSetaraf + '"]');
        bahagianD.removeField('subjek_nama[' + rowIndexSijilSetaraf + ']')
                .removeField('subjek_gred[' + rowIndexSijilSetaraf + ']')
        rowSijilSetaraf.parentNode.removeChild(rowSijilSetaraf);
    };


    const template_bahagianD = document.getElementById('template-sijil-setaraf');
    let rowIndexSijilSetaraf = 0;
    document.getElementById('add-button-sijil-setaraf').addEventListener('click', function () {
        rowIndexSijilSetaraf++;

        const cloneSijilSetaraf = template_bahagianD.cloneNode(true);
        cloneSijilSetaraf.removeAttribute('id');

        cloneSijilSetaraf.style.display = 'flex';

        cloneSijilSetaraf.setAttribute('data-row-index-sijil-setaraf', rowIndexSijilSetaraf);

        template_bahagianD.before(cloneSijilSetaraf);

        let nama_subjek = cloneSijilSetaraf.querySelector('[data-name="subjek.nama"]');
        let gred_subjek = cloneSijilSetaraf.querySelector('[data-name="subjek.gred"]');

        nama_subjek.setAttribute('name', 'subjek_nama[' + rowIndexSijilSetaraf + ']');
        // nama_subjek.setAttribute('name', 'subjek[' + rowIndexSijilSetaraf + '].nama');
        nama_subjek.value = '';

        // gred_subjek.setAttribute('name', 'subjek[' + rowIndexSijilSetaraf + '].gred');
        gred_subjek.setAttribute('name', 'subjek_gred[' + rowIndexSijilSetaraf + ']');
        gred_subjek.value = '';

        let button_remove_sijil_setaraf = cloneSijilSetaraf.querySelector('.js-remove-button-sijil-setaraf');
        let button_remove_icon_sijil_setaraf = cloneSijilSetaraf.querySelector('.js-remove-button-sijil-setaraf-icon');

        button_remove_sijil_setaraf.setAttribute('data-row-index-sijil-setaraf', rowIndexSijilSetaraf);
        button_remove_icon_sijil_setaraf.setAttribute('data-row-index-sijil-setaraf', rowIndexSijilSetaraf);

        button_remove_sijil_setaraf.addEventListener('click', function (e) {
            const index = e.target.getAttribute('data-row-index-sijil-setaraf');
            removeRowSijilSetaraf(index);
        });
        button_remove_icon_sijil_setaraf.addEventListener('click', function (e) {
            const index = e.target.getAttribute('data-row-index-sijil-setaraf');
            removeRowSijilSetaraf(index);
        });

        // bahagianD.addField('subjek[' + rowIndexSijilSetaraf + '].nama', namaSijilSetarafValidators)
        //         .addField('subjek[' + rowIndexSijilSetaraf + '].gred', gredSijilSetarafValidators)
        bahagianD.addField('subjek_nama[' + rowIndexSijilSetaraf + ']', namaSijilSetarafValidators)
                .addField('subjek_gred[' + rowIndexSijilSetaraf + ']', gredSijilSetarafValidators)
    });

    $("#salin_alamat_tetap").click(function(){
        $("#alamat_surat").val($("#alamat_tetap").val());
        $("#bandar_surat").val($("#bandar_tetap").val());
        $("#negeri_surat").val($("#negeri_tetap").val());
        $("#poskod_surat").val($("#poskod_tetap").val());
    });



</script>
@endsection
