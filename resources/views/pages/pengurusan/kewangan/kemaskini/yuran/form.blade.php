@extends('layouts.master.main')
@section('css')
<style>
.hide {
    display: none;
}
</style>
@endsection
@section('content')

<div id="kt_app_content" class="app-content flex-column-fluid">
    <div id="kt_app_content_container" class="app-container container-xxl">
        <div class="row g-5 g-xl-10 mb-3 mb-xl-4">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <!-- SEARCH -->
            </div>
        </div>
        <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
            <div class="col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Maklumat Yuran</h3>
                    </div>

                    <form id="formYuranModal" method="POST" action="{{ $action }}">
                        @if($model->id) @method('PUT') @endif
                        @csrf
                        <div class="card-body py-5">
                            <div class="row mb-2">
                                {{ Form::label('nama', 'Nama Yuran', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}
                                <div class="col-lg-8">
                                    {{ Form::text('nama', $model->nama ?? old('nama'), ['class' => 'form-control form-control-sm ' . ($errors->has('nama') ? 'is-invalid':''), 'id' => 'nama', 'onkeydown' => 'return true', 'autocomplete' => 'off', 'required' => 'required']) }}
                                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            <!-- <div class="row mb-2">
                                {{ Form::label('amaun', 'Amaun Yuran', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required']) }}
                                <div class="col-lg-8">
                                    {{ Form::number('amaun', $model->amaun ?? old('amaun'), ['class' => 'form-control form-control-sm ' . ($errors->has('amaun') ? 'is-invalid':''), 'id' => 'amaun', 'onkeydown' => 'return true', 'autocomplete' => 'off', 'required' => 'required']) }}
                                    @error('amaun') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div> -->
                            <input type="hidden" name="status" value="1">
                            <!-- <div class="row mb-0">
                                {{ Form::label('status', 'Status', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 required pb-0']) }}
                                <div class="col-lg-8 d-flex align-items-center">
                                    <div class="form-check form-check-solid form-switch form-check-custom fv-row">
                                        {{ Form::checkbox('status', '1', $model->status, ['class' => 'form-check-input h-25px w-60px']); }}
                                        <label class="form-check-label fs-7 fw-semibold" for="allowmarketing">Aktif</label>
                                    </div>
                                </div>
                            </div> -->


                            <hr>
                            <div class="row mb-2">
                                <div class="col-lg-12">
                                    <table id="tableCaj" class="table table-bordered table-striped">
                                        <thead>
                                            <th>
                                                {{ Form::label('nama_yuran', 'Nama Caj', ['class' => 'col-form-label fw-semibold fs-7 required']) }}
                                            </th>
                                            <th>
                                                {{ Form::label('amaun', 'Amaun', ['class' => 'col-form-label fw-semibold fs-7 required']) }}                                                
                                            </th>
                                            <td style="width:20px"></td>
                                        </thead>
                                        <tbody id="tbodyCaj">
                                            @php $i = 1; @endphp
                                            @forelse($yuran_detail as $yuran)
                                            <tr>
                                                <td>
                                                    {{ Form::text('nama_yuran[]', $yuran->nama, ['class' => 'form-control form-control-sm ', 'onkeydown' => 'return true', 'autocomplete' => 'off', 'required' => 'required']) }}
                                                </td>
                                                <td>
                                                    {{ Form::number('amaun[]', $yuran->amaun, ['class' => 'form-control form-control-sm ', 'onkeydown' => 'return true', 'autocomplete' => 'off', 'required' => 'required']) }}
                                                </td>
                                                <td>
                                                    @if($i != 1)
                                                    <button type="button" class="btn btn-danger btn-sm float-end btn-remove-tr"><i class="fa fa-minus"></i></button>
                                                    @endif
                                                </td>
                                            </tr>
                                            @php $i++; @endphp
                                            @empty
                                            <tr>
                                                <td>
                                                    {{ Form::text('nama_yuran[]', '', ['class' => 'form-control form-control-sm ', 'onkeydown' => 'return true', 'autocomplete' => 'off', 'required' => 'required']) }}
                                                </td>
                                                <td>
                                                    {{ Form::number('amaun[]', '', ['class' => 'form-control form-control-sm ', 'onkeydown' => 'return true', 'autocomplete' => 'off', 'required' => 'required']) }}
                                                </td>
                                                <td></td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-lg-12">
                                    <button type="button" id="btnAddMore" class="btn btn-success btn-sm float-end"><i class="fa fa-plus"></i></button>
                                </div>
                            </div>

                            <hr>
                            <div class="row mb-2">
                                {{ Form::label('invoice_remarks', 'Nota Invoice', ['class' => 'col-lg-4 col-form-label fw-semibold fs-7 pb-0']) }}
                                <div class="col-lg-8 d-flex align-items-center">
                                    <textarea name="invoice_remarks" class="form-control" rows="4">{{ @$model->invoice_remarks }}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button type="submit" data-kt-ecommerce-settings-type="submit" class="btn btn-success btn-sm me-3">
                                <i class="fa fa-save" style="vertical-align: initial"></i>Simpan
                            </button>
                            <a href="{{ route('pengurusan.kewangan.kemaskini.yuran.index') }}" class="btn btn-light btn-sm">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
@section('script')
@endsection

@push('scripts')

<script>
    $('#btnAddMore').on('click', function(){
        // $html = $('.tr-caj-copy').clone().removeClass('tr-caj-copy hide').addClass('top-parent');
        // $html.appendTo('#tbodyCaj');
        $html = '<tr class="tr-caj-coy">';
        $html += '<td><input class="form-control form-control-sm " onkeydown="return true" autocomplete="off" required="required" name="nama_yuran[]" type="text" value=""></td>';
        $html += '<td><input class="form-control form-control-sm " onkeydown="return true" autocomplete="off" required="required" name="amaun[]" type="number" value=""></td>';
        $html += '<td><button type="button" class="btn btn-danger btn-sm float-end btn-remove-tr"><i class="fa fa-minus"></i></button></td>';
        '</tr>';
        $('#tbodyCaj').append($html);
    })
    $("#tableCaj").on('click', '.btn-remove-tr', function(elem){
        // $(this).closest('.top-parent').remove();
        $(this).parent().parent().remove();
    })
</script>
@endpush