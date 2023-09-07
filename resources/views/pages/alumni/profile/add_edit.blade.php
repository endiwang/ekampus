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
                            <form class="form" action="{{ $action }}" method="post">
                                @method('PUT')
                                @csrf
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('nama', 'Nama', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('nama', $pelajar->nama, ['class' => 'form-control form-control-sm', 'id' => 'nama', 'onkeydown' => 'return true', 'readonly', 'disabled']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('no_ic', 'No IC', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('no_ic', $pelajar->no_ic, ['class' => 'form-control form-control-sm', 'id' => 'no_ic', 'readonly', 'disabled']) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('no_matrik', 'No Matrik', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('no_matrik', $pelajar->no_matrik ?? old('no_matrik'), ['class' => 'form-control form-control-sm ' . ($errors->has('no_matrik') ? 'is-invalid' : ''), 'id' => 'no_matrik', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                            @error('no_matrik')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('email', 'E-mel', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('email', $pelajar->email ?? old('email'), ['class' => 'form-control form-control-sm ' . ($errors->has('email') ? 'is-invalid' : ''), 'id' => 'email', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('np_tel', 'No Telefon', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('no_tel', $pelajar->no_tel ?? old('no_tel'), ['class' => 'form-control form-control-sm ' . ($errors->has('no_tel') ? 'is-invalid' : ''), 'id' => 'no_tel', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                            @error('no_tel')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('alamat', 'Alamat', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::textarea('alamat', $pelajar->alamat ?? old('alamat'), ['class' => 'form-control form-control-sm ' . ($errors->has('alamat') ? 'is-invalid' : ''), 'id' => 'alamat', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                            @error('alamat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('poskod', 'Poskod', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('poskod', $pelajar->poskod ?? old('poskod'), ['class' => 'form-control form-control-sm ' . ($errors->has('poskod') ? 'is-invalid' : ''), 'id' => 'poskod', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                            @error('poskod')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('bandar', 'Bandar', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('bandar', $pelajar->bandar ?? old('bandar'), ['class' => 'form-control form-control-sm ' . ($errors->has('bandar') ? 'is-invalid' : ''), 'id' => 'bandar', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                            @error('bandar')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                        <div class="d-flex">
                                            <button type="submit" data-kt-ecommerce-settings-type="submit"
                                                class="btn btn-success btn-sm me-3">
                                                <i class="fa fa-paper-plane" style="vertical-align: initial"></i>Kemaskini
                                            </button>
                                            <a href="{{ route('alumni.profile.edit', $pelajar->id) }}"
                                                class="btn btn-sm btn-light">Kembali</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="card" id="advanceSearch">
                        <div class="card-header">
                            <h3 class="card-title">Maklumat pengajian selepas Darul Quran</h3>
                        </div>
                        <div class="card-body py-5">
                            <div class="row fv-row mb-2">
                                <div class="col-md-12">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <a href="{{ route('alumni.profile.pengajian.create', $pelajar->id) }}"
                                            id="pengajian_tambah_buton"
                                            class="btn btn-primary btn-sm fw-bold flex-shrink-0">
                                            <i class="fa fa-plus-circle" style="vertical-align: initial"></i>Tambah
                                            Pengajian
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{ $dataTable->table(['class' => 'table table-striped table-row-bordered gy-5 gs-7 border rounded']) }}
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
            @php
                $industri = [
                    'tmk' => 'Teknologi Maklumat dan Komunikasi',
                    'kewangan' => 'Kewangan dan Perbankan',
                    'kesihatan' => 'Perubatan dan Kesihatan',
                    'pengilangan' => 'Pengilangan dan Pembuatan',
                    'peruncitan' => 'Peruncitan dan Jualan Runcit',
                    'pengangkutan' => 'Pengangkutan dan Logistik',
                    'perhotelan' => 'Perhotelan dan Pelancongan',
                    'seni_hiburan' => 'Seni, Hiburan, dan Media',
                    'pendidikan' => 'Pendidikan dan Latihan',
                    'pertanian' => 'Pertanian dan Penternakan',
                    'automotif' => 'Automotif',
                    'reka_bentuk' => 'Reka Bentuk dan Kreatif',
                    'pembinaan' => 'Pembinaan dan Pembangunan',
                    'tenaga' => 'Tenaga dan Alam Sekitar',
                    'sains' => 'Sains dan Penyelidikan',
                    'perkhidmatan_kerajaan' => 'Perkhidmatan Masyarakat dan Kerajaan',
                    'minyak_gas' => 'Pembahagian Minyak dan Gas',
                    'sumber_manusia' => 'Sumber Manusia dan Pengurusan',
                    'telekomunikasi' => 'Telekomunikasi',
                    'e_dagang' => 'E-dagang dan Perdagangan Elektronik',
                    'kejuruteraan' => 'Kejuruteraan dan Teknologi',
                ];
                
            @endphp
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="card" id="advanceSearch">
                        <div class="card-header">
                            <h3 class="card-title">Maklumat pekerjaan terkini</h3>
                        </div>
                        <div class="card-body py-5">
                            <form class="form" action="{{ route('alumni.profile.pekerjaan.store', $pelajar->id) }}"
                                method="post">
                                @if ($pekerjaanData->id)
                                    @method('PUT')
                                @endif
                                @csrf
                                <input type="hidden" name="id" value="{{ $pekerjaanData->id }}">
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('nama_syarikat', 'Nama Syarikat', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('nama_syarikat', $pekerjaanData->nama_syarikat ?? old('nama_syarikat'), ['class' => 'form-control form-control-sm ' . ($errors->has('nama_syarikat') ? 'is-invalid' : ''), 'id' => 'nama_syarikat', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                            @error('nama_syarikat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('jawatan', 'Jawatan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('jawatan', $pekerjaanData->jawatan ?? old('jawatan'), ['class' => 'form-control form-control-sm ' . ($errors->has('jawatan') ? 'is-invalid' : ''), 'id' => 'jawatan', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                            @error('jawatan')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tarikh_mula', 'Tarikh Mula Bekerja', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::date('tarikh_mula', $pekerjaanData->tarikh_mula ?? old('tarikh_mula'), ['placeholder' => 'Sila Pilih', 'class' => 'form-control form-control-sm' . ($errors->has('tarikh_mula') ? 'is-invalid' : ''), 'id' => 'tarikh_mula']) }}
                                            @error('tarikh_mula')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('bidang_industri', 'Bidang Industri', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('bidang_industri', $industri, $pekerjaanData->bidang_industri ?? old('bidang_industri'), [
                                                'placeholder' => 'Sila Pilih',
                                                'class' => 'form-contorl form-select form-select-sm ' . ($errors->has('bidang_industri') ? 'is-invalid' : ''),
                                                'id' => 'bidang_industri',
                                                'data-control' => 'select2',
                                                'required' => 'required',
                                            ]) }}
                                            @error('bidang_industri')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                        <div class="d-flex">
                                            <button type="submit" data-kt-ecommerce-settings-type="submit"
                                                class="btn btn-success btn-sm me-3">
                                                <i class="fa fa-paper-plane" style="vertical-align: initial"></i>Kemaskini
                                            </button>
                                            <a href="{{ route('alumni.profile.edit', $pelajar->id) }}"
                                                class="btn btn-sm btn-light">Kembali</a>
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
    {!! $dataTable->scripts() !!}

    <script>
        // $("#tarikh_kes").daterangepicker({
        //     autoApply: true,
        //     singleDatePicker: true,
        //     showDropdowns: true,
        //     autoUpdateInput: false,
        //     minYear: parseInt(moment().subtract(1, 'y').format("YYYY")),
        //     maxYear: parseInt(moment().add(4, 'y').format("YYYY")),
        //     locale: {
        //         format: 'DD/MM/YYYY'
        //     }
        // }, function(start, end, label) {
        //     var datePicked = moment(start).format('DD/MM/YYYY');
        //     $("#tarikh_kes").val(datePicked);
        // });

        function remove(id) {
            Swal.fire({
                    title: 'Are you sure you want to delete this data?',
                    text: 'This action cannot be undone.',
                    showCancelButton: true,
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Delete',
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
                    if (result.isConfirmed) {
                        document.getElementById(`delete-${id}`).submit();
                    }
                })
        }

        const {
            createApp
        } = Vue

        createApp({
            data() {
                return {
                    table: null,
                    keyword: {
                        search: null,
                    }
                }
            },
            methods: {
                viewMore() {
                    this.show_section_1 = false;
                    this.show_section_2 = true;
                },
                hideMore() {
                    this.show_section_1 = true;
                    this.show_section_2 = false;
                },
                search() {
                    console.log(this.search);
                    this.search(this.keyword.search).draw();
                },
            },
            mounted() {

            },
        }).mount('#advanceSearch')
    </script>
@endpush
