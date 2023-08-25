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
<div class="modal fade" id="yuranModal" tabindex="-1" aria-labelledby="yuranModalLabel" aria-hidden="true">
    <form id="formYuranModal" method="POST" action="">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="yuranModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="yuranModalBody">
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

$('.btn-add-yuran').on('click', function(){
    formModal('Tambah Yuran', '{{ $btn_create_url }}', '{{ $btn_create_action }}')
});
$('table').on('click', '.btn-edit-yuran', function(){
    if($(this).data('url') && $(this).data('action'))
    formModal('Kemaskini Yuran', $(this).data('url'), $(this).data('action'))
});

function formModal(label, url, action)
{
    var myModal = new bootstrap.Modal(document.getElementById('yuranModal'), {})

    $('#yuranModalLabel').html('');
    $('#formYuranModal').attr('action', '');
    $('#yuranModalBody').html('');

    $.ajax({
        type: 'GET',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        url: url,
        success: function (data) {
            $('#yuranModalLabel').html(label);
            $('#formYuranModal').attr('action', action);
            $('#yuranModalBody').html(data);
            myModal.show()
        },
        error: function (data) {
            //                
        }
    });
}

function remove(id){
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
        if(result.isConfirmed){
            document.getElementById(`delete-${id}`).submit();
        }
    })
}
</script>
{!! $dataTable->scripts() !!}
@endpush
