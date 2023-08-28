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
                                    {{ Form::label('kursus', 'Kursus', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('kursus', $courses, $model->kursus_id, ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('kursus') ? 'is-invalid':''), 'data-control'=>'select2' ]) }}
                                        @error('kursus') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kandungan', 'Kandungan Pembelajaran', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('kandungan', $kandungan, $model->syllabus_id, ['placeholder' => 'Sila Pilih','class' =>'form-control form-select form-select-sm '.($errors->has('kandungan') ? 'is-invalid':''), 'id'=>'kandungan' ]) }}
                                        @error('kandungan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('semester', 'Semester', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('semester', $semesters, $model->semester_id ?? old('semester'), ['placeholder' => 'Sila Pilih','class' =>'form-control form-select form-select-sm '.($errors->has('semester') ? 'is-invalid':''), 'data-control'=>'select2' ]) }}
                                        @error('jantina') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('pensyarah', 'Pensyarah', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('pensyarah', $lecturers, $model->staff_id ?? old('pensyarah'), ['placeholder' => 'Sila Pilih','class' =>'form-control form-select form-select-sm '.($errors->has('pensyarah') ? 'is-invalid':''), 'data-control'=>'select2' ]) }}
                                        @error('jantina') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2">
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
                            <div class="row fv-row mb-2">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('masa_tamat', 'Masa Tamat', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        <input type="time" id="masa_tamat" name="masa_tamat" value="{{$model->masa_akhir ?? null}}" class="form-control form-control-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="row fv-row mb-2" >
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('kelas', 'Kelas', ['class' => 'fs-7 fw-semibold required form-label mt-2']) }}
                                </div>
                                <div class="col-md-9">
                                    <div class="w-100">
                                        {{ Form::select('kelas', $classes, $model->kelas_id ?? old('kelas'), ['placeholder' => 'Sila Pilih','class' =>'form-contorl form-select form-select-sm '.($errors->has('pensyarah') ? 'is-invalid':''), 'data-control'=>'select2' ]) }}
                                        @error('jantina') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-3 text-md-end">
                                    {{ Form::label('status', 'Status', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required pb-0']) }}
                                </div>
                                
                                <div class="col-lg-9">
                                    <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                        {{ Form::checkbox('status', '1', $model->status ?? old('status'), ['class' => 'form-check-input h-25px w-60px']); }}
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
                                        <a href="{{ route('pengurusan.akademik.e_learning.jadual_pembelajaran.index') }}" class="btn btn-sm btn-light">Batal</a>
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
<script>
    $(document).ready(function () {
        if($("#kursus").val() != null || $("#kursus").val() != '')
        {
            $("#kandungan").select2({
                ajax: {
                    url: "{{route('pengurusan.akademik.e_learning.jadual_pembelajaran.fetchContent')}}",
                    type: "POST",
                    data: {
                                kursus_id: $("#kursus").val(),
                                _token: '{{csrf_token()}}'
                            },
                    dataType: 'json',
                    processResults: function (data) {
                        console.log(data);
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data
                    };
                    }
                }
            })
        }

        $("#kursus").on('change', function(){
            var kursus_id = this.value;
            console.log(kursus_id)
            $("#kandungan").val('');
            $("#kandungan").select2({
                ajax: {
                    url: "{{route('pengurusan.akademik.e_learning.jadual_pembelajaran.fetchContent')}}",
                    type: "POST",
                    data: {
                                kursus_id: kursus_id,
                                _token: '{{csrf_token()}}'
                            },
                    dataType: 'json',
                    processResults: function (data) {
                        console.log(data);
                    // Transforms the top-level key of the response object from 'items' to 'results'
                    return {
                        results: data
                    };
                    }
                }
            })
        })
    });
</script>
@endpush

