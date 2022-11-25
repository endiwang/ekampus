@extends('layouts.public.inner_page')
@section('content')
    <div class="py-10 py-lg-20">
        <div id="kt_app_content" class="app-content flex-column-fluid">
            <div id="kt_app_content_container" class="app-container container-xxl">
                @include('form.permohonan.a_maklumat_pemohon')
                @include('form.permohonan.b_maklumat_pemohon')
                @include('form.permohonan.c_kelulusan_akademik')
                @include('form.permohonan.d_maklumat_akademik')
                @include('form.permohonan.e_maklumat_ibu_bapa_penjaga')
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
                    ]
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

    const formE = createApp(
        {
            data() {
                return {
                    tanggungan : [
                    ],
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
