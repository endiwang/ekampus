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
                                    {{ Form::label('jenis', 'Jenis', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <select
                                            name="jenis"
                                            @change="onChange($event)"
                                            class="orm-control form-select form-select-sm"
                                            v-model="select_type"
                                        >
                                        <option value="">Pilih Jenis</option>
                                        <option value="ganti" @if(!empty($model->jenis) && $model->jenis == 'ganti') selected @endif>Ganti Pensyarah</option>
                                        <option value="tidak_hadir" @if(!empty($model->jenis) && $model->jenis == 'tidak_hadir') selected @endif>Tidak Hadir</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('subjek', 'Subjek', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <select class="form-control form-select form-select-sm" data-control="select2" name="subjek" id="subjek">
                                            <option value="">Pilih Subjek</option>
                                            @foreach($subjects as $key => $value)
                                            <option value="{{ $key }}" @if(!empty($model->subjek_id) && $key == $model->subjek_id) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('tarikh', 'Tarikh', ['class' => 'fs-7 fw-semibold form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::text('tarikh', $model->tarikh ?? old('tarikh'),['class' => 'form-control form-control-sm '.($errors->has('tarikh') ? 'is-invalid':''), 'id' =>'tarikh','onkeydown' =>'return true','autocomplete' => 'off']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2"  v-show="isVisible">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('masa_mula', 'Masa Mula', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="time" id="masa_mula" name="masa_mula" value="{{$model->masa_mula ?? null}}" class="form-control form-control-sm">
                                        @error('masa_mula') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" v-show="isVisible">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('masa_tamat', 'Masa Tamat', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="time" id="masa_tamat" name="masa_tamat" value="{{$model->masa_tamat ?? null}}" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kelas', 'Kelas', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <select class="form-control form-select form-select-sm" data-control="select2" name="kelas" id="kelas">
                                            <option value="">Pilih Kelas</option>
                                            @foreach($kelas as $key => $value)
                                            <option value="{{ $key }}" @if(!empty($model->kelas_id) && $key == $model->kelas_id) selected @endif>{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('catatan', 'Catatan', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::textarea('catatan', $model->catatan ?? null,['class' => 'form-control form-control-sm ', 'id' =>'catatan', 'rows'=>'3']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status', 'Status', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required pb-0']) }}
                                </div>
                                
                                <div class="col-lg-9">
                                    <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                        {{ Form::checkbox('status', '1', $model->status, ['class' => 'form-check-input h-25px w-60px']); }}
                                        <label class="form-check-label fs-7 fw-semibold" for="allowmarketing">Aktif</label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="staff_id" value="{{ $id ?? null}}">
                            
                            <div class="row mt-3">
                                <div class="col-md-9 offset-md-3">
                                    <div class="d-flex">
                                        <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                            <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                                        </button>
                                        <a href="{{ route('pengurusan.akademik.pengurusan_jabatan.jadual_penggantian_pensyarah.show', $id) }}" class="btn btn-sm btn-light">Batal</a>
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
            select_type : '',
            showSection : false,
        }
    },
    methods: {
            onChange(event) {
                console.log(event.target.value)
                if(event.target.value == 'ganti')
                {
                    console.log("here");
                    this.showSection = true;
                }
                else {
                    this.showSection = false;
                }
            
            },
            
        },
    computed:{
        isVisible(){
            return  this.showSection;
        }
    },
    mounted() {
        
        },
    }).mount('#advanceSearch')

    $("#tarikh").daterangepicker({
        autoApply : true,
        singleDatePicker: true,
        showDropdowns: true,
        autoUpdateInput: false,
        minYear: parseInt(moment().subtract(1,'y').format("YYYY")),
        maxYear: parseInt(moment().add(4,'y').format("YYYY")),
        locale: {
            format: 'DD/MM/YYYY'
        }
        },function(start, end, label) {
            var datePicked = moment(start).format('DD/MM/YYYY');
            $("#tarikh").val(datePicked);
        });
</script>
@endsection
