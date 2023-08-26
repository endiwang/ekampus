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
                    @if($model->id)
                        <form class="form" action="{{url('pengurusan/pentadbiran/kuarters/permohonan/update')}}" method="post" enctype="multipart/form-data">
                        
                    @else
                        <form class="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                        
                        
                    @endif
                            @csrf
                            @if($model->id) @method('POST') <input type="hidden" name="id" value="{{data_get($model,'id')}}" /> @endif
                            
                            <div class="card-header">
                                <h3 class="card-title">Butiran Peribadi</h3>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama', 'Nama', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama', $model->nama ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('no_pengenalan', 'No Kad Pengenalan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('no_pengenalan', $model->no_pengenalan ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('no_pengenalan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                        
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('warganegara', 'Warganegara', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        
                                        {{ Form::select('warganegara', $warganegara, $model->warganegara, ['disabled' => 'disabled','placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('bilik') ? 'is-invalid':'') ]) }}                                                                                
                                        @error('warganegara') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status_perkahwinan', 'Status Perkahwinan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        
                                        {{ Form::select('status_perkahwinan', $statuskahwin, $model->status_perkahwinan, ['disabled' => 'disabled','placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('bilik') ? 'is-invalid':'') ]) }}                                                                                
                                        @error('status_perkahwinan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('nama_pasangan', 'Nama Pasangan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('nama_pasangan', $model->nama_pasangan ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('nama_pasangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>                                                                                                                        
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('bil_anak', 'Bil Anak', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::number('bil_anak', $model->bil_anak ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('bil_anak') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('bil_oku', 'Bil Anak Oku (jika ada)', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::number('bil_oku', $model->bil_oku ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('bil_oku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>  
                                
                            
                            
                            <div class="card-header">
                                <h3 class="card-title">Butiran Pekerjaan</h3>
                            </div>


                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jawatan_gred', 'Jawatan/Gred', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('jawatan_gred', $model->jawatan_gred ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('jawatan_gred') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('gaji_pokok', 'Gaji Pokok', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::number('gaji_pokok', $model->gaji_pokok ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('gaji_pokok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_khidmat_kerajaan', 'Tarikh Mula Berkhidmat Dengan Kerajaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::date('tarikh_khidmat_kerajaan', $model->tarikh_khidmat_kerajaan ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('tarikh_khidmat_kerajaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh_khidmat_dq', 'Tarikh Mula Berkhidmat Di Darul Quran', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::date('tarikh_khidmat_dq', $model->tarikh_khidmat_dq ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('tarikh_khidmat_dq') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>

                            
                            

                            <div class="card-header">
                                <h3 class="card-title">Butiran Tempat Tinggal</h3>
                            </div>

                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('alamat_sekarang', 'Alamat Sekarang', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('alamat_sekarang', $model->alamat_sekarang ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('alamat_sekarang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('alamat_rumah', 'Alamat Rumah Sendiri (jika ada)', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('alamat_rumah', $model->alamat_rumah ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('alamat_rumah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('cara_beli_rumah', 'Cara Pembelian Rumah Sendiri', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        
                                        {{ Form::select('cara_beli_rumah', $carabelirumah, $model->cara_beli_rumah, ['disabled' => 'disabled','placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('bilik') ? 'is-invalid':'') ]) }}                                                                                
                                        @error('cara_beli_rumah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jarak_rumah_dq', 'Jarak antara Rumah ke Darul Quran (KM)', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::number('jarak_rumah_dq', $model->jarak_rumah_dq ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('jarak_rumah_dq') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <?php 
                                $adabelirumah = [
                                    1 => 'Ya',
                                    2 => 'Tidak'
                                ];
                            ?>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('loan_pasangan', 'Nyatakan Suami / Isteri Membuat Penjaman Perumahan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        
                                        {{ Form::select('loan_pasangan', $adabelirumah, $model->loan_pasangan, ['disabled' => 'disabled','placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('bilik') ? 'is-invalid':'') ]) }}                                                                                
                                        @error('loan_pasangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('alamat_sekarang', 'Alamat Rumah Suami/Isteri (jika ada)', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('alamat_sekarang', $model->alamat_sekarang ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('alamat_sekarang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('alasan_mohon', 'Alasan Memohon Kuarters', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('alasan_mohon', $model->alasan_mohon ?? '' ,['disabled' => 'disabled','class' => 'form-control form-control-sm', 'id' =>'peraturan_akademik','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('alasan_mohon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status', 'Tindakan Kelulusan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                    @if(data_get($kakitangan,'staff.jabatan.id') == 14)

                                    {{ Form::select('status', $status, $model->status, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('kategori') ? 'is-invalid':'') ]) }}
                                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror

                                    @else
                                        Maaf Anda bukan dari Unit Pentadbiran
                                    @endif
                                    </div>
                                </div>
                            </div> 


                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>                                    
                                        <a class="btn btn-sm btn-light" onclick="history.back()">Batal</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--end::Row-->
    </div>
</div>
@endsection

@push('scripts')

@endpush