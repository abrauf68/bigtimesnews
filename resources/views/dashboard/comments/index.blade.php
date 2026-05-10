@extends('layouts.master')

@section('title', __('Comments'))

@section('css')
<style>
    /* Add to your custom CSS file */
.dataTables_processing {
    background: rgba(255, 255, 255, 0.9);
    border: none;
    box-shadow: none;
    font-size: 1.2rem;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
}
</style>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Comments') }}</li>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">{{ __('All Comments') }}</h5>
                <div class="card-tools">
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ti ti-filter me-1"></i> Filter by Status
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item filter-status" href="#" data-status="all">All</a></li>
                            <li><a class="dropdown-item filter-status" href="#" data-status="pending">Pending</a></li>
                            <li><a class="dropdown-item filter-status" href="#" data-status="approved">Approved</a></li>
                            <li><a class="dropdown-item filter-status" href="#" data-status="spam">Spam</a></li>
                            <li><a class="dropdown-item filter-status" href="#" data-status="trash">Trash</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-comments table border-top" id="comments-table">
                    <thead>
                        <tr>
                            <th>{{ __('Sr.') }}</th>
                            <th>{{ __('Comment') }}</th>
                            <th>{{ __('Post') }}</th>
                            <th>{{ __('Author') }}</th>
                            <th>{{ __('Replies') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th>{{ __('Status') }}</th>
                            @canany(['delete comment', 'update comment', 'view comment'])
                                <th>{{ __('Action') }}</th>
                            @endcan
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var table = $('#comments-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('comments.data') }}",
                    type: "GET",
                    error: function(xhr, error, thrown) {
                        console.log('DataTable Error:', error);
                        toastr.error('Failed to load comments data');
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'content', name: 'content' },
                    { data: 'post', name: 'post', orderable: false },
                    { data: 'user', name: 'user' },
                    { data: 'replies_count', name: 'replies_count', orderable: false, searchable: false },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[5, 'desc']],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
                    emptyTable: 'No comments found',
                    zeroRecords: 'No matching comments found'
                },
                drawCallback: function() {
                    // Reinitialize tooltips
                    $('[data-bs-toggle="tooltip"]').tooltip();

                    // Delete confirmation
                    $('.delete_confirmation').off('click').on('click', function(e) {
                        e.preventDefault();
                        let form = $(this).closest('form');

                        Swal.fire({
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Yes, delete it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                form.submit();
                            }
                        });
                    });

                    // Status update confirmation
                    $('.btn-status-update, .btn-mark-spam').off('click').on('click', function(e) {
                        e.preventDefault();
                        let url = $(this).attr('href');
                        let title = $(this).attr('title');

                        Swal.fire({
                            title: 'Are you sure?',
                            text: `Do you want to ${title.toLowerCase()}?`,
                            icon: 'question',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, do it!'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                $.ajax({
                                    url: url,
                                    type: 'PUT',
                                    data: {
                                        _token: '{{ csrf_token() }}'
                                    },
                                    success: function(response) {
                                        if (response.success) {
                                            toastr.success(response.message);
                                            table.ajax.reload();
                                        } else {
                                            toastr.error(response.message || 'Something went wrong!');
                                        }
                                    },
                                    error: function(xhr) {
                                        toastr.error('Failed to update status!');
                                    }
                                });
                            }
                        });
                    });
                }
            });

            // Filter by status
            $('.filter-status').on('click', function(e) {
                e.preventDefault();
                let status = $(this).data('status');

                if (status === 'all') {
                    table.column('status:name').search('').draw();
                } else {
                    table.column('status:name').search(status).draw();
                }
            });
        });
    </script>
@endsection
