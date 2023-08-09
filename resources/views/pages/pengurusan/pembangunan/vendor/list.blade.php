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


@endsection
@section('script')
@endsection

@push('scripts')
<script>
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
