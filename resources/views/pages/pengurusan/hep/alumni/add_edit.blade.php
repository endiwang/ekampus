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
                                @if ($pelajar->id)
                                    @method('PUT')
                                @endif
                                @csrf
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('nama', 'Nama', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('nama', $pelajar->nama ?? old('nama'), ['class' => 'form-control form-control-sm ' . ($errors->has('nama') ? 'is-invalid' : ''), 'id' => 'nama', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                            @error('nama')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('no_ic', 'No IC', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('no_ic', $pelajar->no_ic ?? old('no_ic'), ['class' => 'form-control form-control-sm ' . ($errors->has('no_ic') ? 'is-invalid' : ''), 'id' => 'no_ic', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                            @error('no_ic')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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
                                            <a href="{{ route('home') }}" class="btn btn-sm btn-light">Kembali</a>
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
                            <form class="form"
                                action="{{ route('pengurusan.hep.alumni.pengajian.store', $pelajar->id) }}" method="POST">
                                @csrf
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('nama_institusi', 'Institusi', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('nama_institusi', old('nama_institusi'), ['class' => 'form-control form-control-sm ' . ($errors->has('nama_institusi') ? 'is-invalid' : ''), 'id' => 'nama_institusi', 'onkeydown' => 'return true', 'autocomplete' => 'off', 'required']) }}
                                            @error('nama_institusi')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tarikh_mula', 'Tarikh mula', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::date('tarikh_mula', old('tarikh_mula'), ['class' => 'form-control form-control-sm ' . ($errors->has('tarikh_mula') ? 'is-invalid' : ''), 'id' => 'tarikh_mula', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                            @error('tarikh_mula')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('tarikh_tamat', 'Tarikh tamat', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::date('tarikh_tamat', old('tarikh_tamat'), ['class' => 'form-control form-control-sm ' . ($errors->has('tarikh_tamat') ? 'is-invalid' : ''), 'id' => 'tarikh_tamat', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                            @error('tarikh_tamat')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-12">
                                        <div class="d-flex align-items-center justify-content-end">
                                            <button id="pengajian_tambah_buton"
                                                class="btn btn-primary btn-sm fw-bold flex-shrink-0">
                                                <i class="fa fa-plus-circle" style="vertical-align: initial"></i>Tambah
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            {{ $dataTable->table(['class' => 'table table-striped table-row-bordered gy-5 gs-7 border rounded']) }}

                            {{-- <form class="form" action="{{ $action }}" method="post">
                                @if ($pelajar->id)
                                    @method('PUT')
                                @endif
                                @csrf

                                <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                        <div class="d-flex">
                                            <button type="submit" data-kt-ecommerce-settings-type="submit"
                                                class="btn btn-success btn-sm me-3">
                                                <i class="fa fa-paper-plane" style="vertical-align: initial"></i>Kemaskini
                                            </button>
                                            <a href="{{ route('home') }}" class="btn btn-sm btn-light">Kembali</a>
                                        </div>
                                    </div>
                                </div>
                            </form> --}}
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                    <div class="card" id="advanceSearch">
                        <div class="card-header">
                            <h3 class="card-title">Maklumat pekerjaan terkini</h3>
                        </div>
                        <div class="card-body py-5">

                            <form class="form" action="{{ $action }}" method="post">
                                @if ($pelajar->id)
                                    @method('PUT')
                                @endif
                                @csrf
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('pelaku_pelajar_id', 'Nama Syarikat', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('pelaku_pelajar_id', $pelajar->id ?? old('pelaku_pelajar_id'), ['class' => 'form-control form-control-sm ' . ($errors->has('no_tel') ? 'is-invalid' : ''), 'id' => 'no_tel', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                            @error('pelaku_pelajar_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('pelaku_pelajar_id', 'Jawatan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('pelaku_pelajar_id', $pelajar->id ?? old('pelaku_pelajar_id'), ['class' => 'form-control form-control-sm ' . ($errors->has('no_tel') ? 'is-invalid' : ''), 'id' => 'no_tel', 'onkeydown' => 'return true', 'autocomplete' => 'off']) }}
                                            @error('pelaku_pelajar_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('pelaku_pelajar_id', 'Tarikh Mula Bekerja', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::date('pelaku_pelajar_id', $pelajar->id ?? old('pelaku_pelajar_id'), ['placeholder' => 'Sila Pilih', 'class' => 'form-control form-control-sm']) }}
                                            @error('pelaku_pelajar_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2">
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('status', 'Bidang Industri', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::select('status', ['tmk' => 'Teknologi Maklumat dan Komunikasi', 'kewangan' => 'Kewangan dan Perbankan', 'kesihatan' => 'Perubatan dan Kesihatan'], $pelajar->nama ?? old('status'), ['placeholder' => 'Sila Pilih', 'class' => 'form-contorl form-select form-select-sm ', 'data-control' => 'select2', 'required' => 'required']) }}
                                            @error('status')
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
                                            <a href="{{ route('home') }}" class="btn btn-sm btn-light">Kembali</a>
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
