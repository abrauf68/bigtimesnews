@extends('layouts.master')

@section('title', __('Posts'))

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
    <li class="breadcrumb-item active">{{ __('Posts') }}</li>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Posts List Table -->
        <div class="card">
            <div class="card-header">
                @canany(['create post'])
                    <a href="{{ route('dashboard.posts.create') }}" class="add-new btn btn-primary waves-effect waves-light">
                        <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i>
                        <span class="d-none d-sm-inline-block">{{ __('Add New Post') }}</span>
                    </a>
                @endcan
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-posts table border-top" id="posts-table">
                    <thead>
                        <tr>
                            <th>{{ __('Sr.') }}</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th>{{ __('Status') }}</th>
                            @canany(['delete post', 'update post', 'view post'])
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
            $('#posts-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('posts.data') }}",
                    type: "GET",
                    error: function(xhr, error, thrown) {
                        console.log('DataTable Error:', error);
                        toastr.error('Failed to load posts data');
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'title', name: 'title' },
                    { data: 'category', name: 'category.name' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'status', name: 'status', orderable: true, searchable: true },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ],
                order: [[4, 'desc']], // Sort by created_at desc
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                language: {
                    processing: '<div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>',
                    emptyTable: 'No posts found',
                    zeroRecords: 'No matching posts found'
                },
                drawCallback: function() {
                    // Reinitialize tooltips
                    $('[data-bs-toggle="tooltip"]').tooltip();

                    // Reinitialize delete confirmation
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
                }
            });
        });
    </script>
@endsection
