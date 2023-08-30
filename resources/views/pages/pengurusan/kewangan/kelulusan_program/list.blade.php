@extends('layouts.master.main')
@section('css')
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
                    <div class="card-body py-5">
                        {{ $dataTable->table(['class'=>'table table-striped table-row-bordered gy-5 gs-7 border rounded']) }}                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="kelulusanModal" tabindex="-1" aria-labelledby="kelulusanModalLabel" aria-hidden="true">
    <form id="formKelulusanModal" method="POST" action="">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="kelulusanModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="kelulusanModalBody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </div>
        </div>
    </form>
</div>

@endsection
@section('script')
@endsection

@push('scripts')
<script>

$('table').on('click', '.btn-edit-kelulusan', function(){
    if($(this).data('url') && $(this).data('action'))
    formModal('Kemaskini Kelulusan', $(this).data('url'), $(this).data('action'))
});

function formModal(label, url, action)
{
    var myModal = new bootstrap.Modal(document.getElementById('kelulusanModal'), {})

    $('#kelulusanModalLabel').html('');
    $('#formKelulusanModal').attr('action', '');
    $('#kelulusanModalBody').html('');

    $.ajax({
        type: 'GET',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        success: function (data) {
            $('#kelulusanModalLabel').html(label);
            $('#formKelulusanModal').attr('action', action);
            $('#kelulusanModalBody').html(data);
            myModal.show()
        },
        error: function (data) {
            //                
        }
    });
}

</script>
{!! $dataTable->scripts() !!}
@endpush
