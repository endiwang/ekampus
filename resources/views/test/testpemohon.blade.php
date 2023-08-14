@extends('layouts.public.inner_page')
@section('content')
    <div class="py-10 py-lg-20">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                @include('pages.pemohon.permohonan.borang.a_maklumat_pemohon')
                @include('pages.pemohon.permohonan.borang.b_tempat_temuduga')
                @include('pages.pemohon.permohonan.borang.c_maklumat_ibu_bapa_penjaga')
                @include('pages.pemohon.permohonan.borang.d_kelulusan_akademik')
                {{-- @include('form.permohonan.e_maklumat_ibu_bapa_penjaga') --}}
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>

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
                },
            }
        }
    ).mount('#formPermohonanD')

    const formE= createApp(
        {
            data() {
                return {
                    tanggungan : [
                    ],
                    showMaklumatBapa : 0,
                    showMaklumatIbu : 0,
                    showMaklumatPenjaga : 0,
                }
            },
            methods: {
                addRowTanggungan(){
                    this.tanggungan.push(
                        {
                            nama: '',
                            institusi: '',
                            umur: '',
                        });
                },
                removeRowTanggungan(index){
                    this.tanggungan.splice(index,1)
                },
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
                }
            }
        }
    ).mount('#formPermohonanE')

</script>

<script>

    $("#tarikh_lahir").daterangepicker({
        singleDatePicker: true,
        autoApply: true,
        autoclose: false,
        alwaysShowCalendars: true,
        showDropdowns: true,
        minYear: 1901,
        locale: {
                    format: 'DD/MM/YYYY'
                },
        maxYear: parseInt(moment().format("YYYY"),12)
    });

</script>
@endsection
