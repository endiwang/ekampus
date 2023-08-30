@extends('layouts.master.main')
@section('css')
@endsection
@section('content')
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
                <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                        <div class="card">
                            <div class="card-body py-5">
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('name', 'Nama', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            {{ Form::text('name',$pusatPeperiksaan->name,['class' => 'form-control form-control-sm '.($errors->has('siri') ? 'is-invalid':''), 'id' =>'siri','autocomplete' => 'off' , 'disabled'=> true]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('negeri', 'Negeri Pusat Peperiksaan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <select name="negeri[]" class="form-select" data-control="select2" data-placeholder="Sila Pilih" data-allow-clear="true" multiple="multiple" data-hide-search="false" disabled>
                                                @foreach ($negeriSelection as $negeri)
                                                @if (in_array($negeri->id, $pusatPeperiksaanNegeri))
                                                    <option value="{{ $negeri->id }}" selected>{{ $negeri->nama }}</option>
                                                @else
                                                    <option value="{{ $negeri->id }}">{{ $negeri->nama }}</option>
                                                @endif
                                                    
                                                @endforeach
                                            </select>
                                            @error('negeri') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row fv-row mb-2" >
                                    <div class="col-md-3 text-md-end">
                                        {{ Form::label('status', 'Status Pusat Peperiksaan', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                    </div>
                                    <div class="col-md-9">
                                        <div class="w-100">
                                            <label class="form-check form-switch form-check-custom form-check-solid">
                                                {{ Form::checkbox('status', $pusatPeperiksaan->status, ($pusatPeperiksaan->status == 0 ? false:true), ['class' => 'form-check-input h-25px w-60px mt-1', 'disabled' => true]); }}
                                                <span class="form-check-label fs-7 fw-semibold mt-2">
                                                    Aktif
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mt-2">
                            <div class="card-body py-5">
                                <div class="row">
                                    <div class="col-md-9 offset-md-3">
                                        <div class="d-flex">
                                            <a href="{{ route('pengurusan.pengajian_sepanjang_hayat.tetapan.pusat_peperiksaan_sijil_tahfiz.index') }}" class="btn btn-light btn-sm">Kembali</a>
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


@endpush
