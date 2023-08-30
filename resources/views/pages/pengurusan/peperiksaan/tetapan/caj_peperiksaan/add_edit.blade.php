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
                        <form class="form" action="{{ $action }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @if($model->id) @method('PUT') @endif
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('jenis', 'Jenis', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <select name="jenis"@change="onChange($event)" class="form-control form-select form-select-sm" 
                                            v-model="select_type">
                                        <option value="">Pilih Jenis</option>
                                        @foreach($types as $key => $value)
                                            <option value="{{ $key }}" @if(!empty($model->jenis) && $model->jenis == $key) selected @endif>{{ $value}}</option>
                                        @endforeach
                                        </select>
                                        @error('jenis') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2"  v-show="isVisible || select_type == 'peperiksaan'">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('description', 'Deskripsi', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <select name="description" @change="onChangeDesc($event)" class="form-control form-select form-select-sm" 
                                            v-model="select_description">
                                        <option value="">Pilih Deskripsi</option>
                                        @foreach($descriptions as $key => $value)
                                            <option value="{{ $key }}" @if(!empty($model->description) && $model->description == $key) selected @endif>{{ $value}}</option>
                                        @endforeach
                                        </select>
                                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" v-show="isShow || select_description == 'subjek' || select_description == 'subjek_ulangan'">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('subjek', 'Subjek', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('subjek', $subjects, $model->subjek_id ?? old('subjek'), ['data-control'=>'select2', 'placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm','id'=>'subjek' ]) }}
                                        @error('subjek') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('amaun', 'Amaun (RM)', ['class' => 'fs-7 fw-semibold form-label mt-2 required']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('amaun', $model->jumlah ?? old('amaun') ,['class' => 'form-control form-control-sm', 'id' =>'amaun','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                        @error('amaun') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status', 'Status', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <label class="form-check form-switch form-check-custom form-check-solid">
                                            {{ Form::checkbox('status', '0', ($model->status == 0 ? true:false), ['class' => 'form-check-input h-25px w-60px']); }}
                                            <span class="form-check-label fs-7 fw-semibold mt-2">
                                                Aktif
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pengurusan.peperiksaan.tetapan.caj_peperiksaan.index') }}" class="btn btn-sm btn-light">Batal</a>
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

@section('script')
<script>
    const { createApp } = Vue
    createApp({
        
    data() {
        return {
            select_type : "{!! $model->jenis !!}",
            select_description : "{!! $model->description !!}",
            showSection : false,
            showSubject : false,
        }
    },
    methods: {
            onChange(event) {
                if(event.target.value == 'peperiksaan')
                {
                    this.showSection = true;
                }
                else {
                    this.showSection = false;
                }
            },
            onChangeDesc(event) {
                if(event.target.value == 'subjek' || event.target.value == 'subjek_ulangan')
                {
                    this.showSubject = true;
                }
                else {
                    this.showSubject = false;
                }
            },
            
        },
    computed:{
        isVisible(){
            return this.showSection;
        },
        isShow(){
            return this.showSubject;
        }
    },
    mounted() {
        
        },
    }).mount('#advanceSearch')
</script>
@endsection
