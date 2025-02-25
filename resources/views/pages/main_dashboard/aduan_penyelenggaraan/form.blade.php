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
                    <form class="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                        @if($model->id) @method('PUT') @endif
                        @csrf
                        <div class="card-body py-5">
                            <div class="row mb-2">                                
                                {{ Form::label('kategori', 'Kategori', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::select('kategori', $kategori_aduan, @$model->kategori, ['placeholder' => 'Sila Pilih', 'class' => 'form-contorl form-select form-select-sm ' . ($errors->has('kategori') ? 'is-invalid' : ''), 'required' => 'required' ]) }}
                                    @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row mb-2">                                
                                {{ Form::label('type', 'Lokasi', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::select('type', $lokasi, @$model->type, ['placeholder' => 'Sila Pilih', 'class' => 'form-contorl form-select form-select-sm ' . ($errors->has('type') ? 'is-invalid' : ''), 'required' => 'required' ]) }}
                                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row mb-2">                                
                                {{ Form::label('blok_id', 'Bangunan', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::select('blok_id', [], @$model->blok_id, ['placeholder' => 'Sila Pilih', 'class' => 'form-contorl form-select form-select-sm ' . ($errors->has('blok_id') ? 'is-invalid' : ''), 'required' => 'required' ]) }}
                                    @error('blok_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row mb-2">                                
                                {{ Form::label('tingkat_id', 'Tingkat', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::select('tingkat_id', $tingkat, @$model->tingkat_id, ['placeholder' => 'Sila Pilih', 'class' => 'form-contorl form-select form-select-sm ' . ($errors->has('tingkat_id') ? 'is-invalid' : ''), 'required' => 'required' ]) }}
                                    @error('tingkat_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row mb-2">                                
                                {{ Form::label('bilik_id', 'Bilik', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::select('bilik_id', [], @$model->bilik_id, ['placeholder' => 'Sila Pilih', 'class' => 'form-contorl form-select form-select-sm ' . ($errors->has('bilik_id') ? 'is-invalid' : ''), 'required' => 'required' ]) }}
                                    @error('bilik_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <div class="row mb-2">                                
                                {{ Form::label('jenis_kerosakan', 'Jenis Kerosakan', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::text('jenis_kerosakan', @$model->jenis_kerosakan ?? old('jenis_kerosakan'), ['class' => 'form-control form-control-sm ' . ($errors->has('jenis_kerosakan') ? 'is-invalid' : ''), 'id' =>'jenis_kerosakan', 'onkeydown' =>'return true', 'autocomplete' => 'off', 'required' => 'required']) }}
                                    @error('jenis_kerosakan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row fv-row mb-2">                                
                                {{ Form::label('butiran', 'Butiran', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}                                
                                <div class="col-lg-8">                                    
                                    {{ Form::textarea('butiran', @$model->butiran, ['class' => 'form-control form-control-sm ' . ($errors->has('jenis_kerosakan') ? 'is-invalid' : ''), 'rows'=>'10', 'required' => 'required', 'id' =>'butiran']) }}
                                    @error('butiran') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="row fv-row mb-2">
                                {{ Form::label('gambar', '', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7']) }}
                                <div class="col-lg-8">                                    
                                    {{ Form::file('gambar[]', ['class' => 'form-control form-control-sm ' . ($errors->has('gambar') ? 'is-invalid' : ''), 'rows'=>'4', 'id' =>'gambar', 'multiple']) }}
                                    @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>


                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                            </button>
                            <a href="{{ route('aduan_penyelenggaraan.index') }}" class="btn btn-sm btn-light">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end::Row-->

    </div>
</div>
@endsection

@push('scripts')
<script>
$('[name="type"]').on('change', function(){
    if($(this).val())
    {
        $.ajax({
            type: 'GET',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            url: "{{ route('aduan_penyelenggaraan.get_block') }}",
            data: {
                type: $(this).val(),
            },
            success: function (data) {

                var $select = $('[name="blok_id"]');                        
                $select.find('option').remove();

                $select.append(`<option value="">Sila Pilih</option>`);
                $.each(data.blok, function(key, value) {
                    $select.append(`<option value="${key}">${value}</option>`);
                });
            },
            error: function (data) {
                //                
            }
        });
    }
})
$('[name="blok_id"], [name="tingkat_id"]').on('change', function(){
    if($('[name="blok_id"]').val() && $('[name="tingkat_id"]').val())
    {
        console.log('aa');
        $.ajax({
            type: 'GET',
            headers: {
                'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            },
            dataType: 'json',
            url: "{{ route('aduan_penyelenggaraan.get_bilik') }}",
            data: {
                blok_id: $('[name="blok_id"]').val(),
                tingkat_id: $('[name="tingkat_id"]').val(),
            },
            success: function (data) {
                
                var $select = $('[name="bilik_id"]');                        
                $select.find('option').remove();

                $select.append(`<option value="">Sila Pilih</option>`);
                $.each(data.bilik, function(key, value) {
                    $select.append(`<option value="${key}">${value}</option>`);
                });
            },
            error: function (data) {
                //                
            }
        });
    }
})
</script>
@endpush
