@extends('layouts.master')

@section('title', __('Posts'))

@section('css')
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
                        <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                            class="d-none d-sm-inline-block">{{ __('Add New Post') }}</span>
                    </a>
                @endcan
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table border-top custom-datatables">
                    <thead>
                        <tr>
                            <th>{{ __('Sr.') }}</th>
                            <th>{{ __('Title') }}</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Author') }}</th>
                            <th>{{ __('Created At') }}</th>
                            <th>{{ __('Status') }}</th>
                            @canany(['delete post', 'update post', 'view post'])<th>{{ __('Action') }}</th>@endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $index => $post)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($post->title, 20, '...') }}</td>
                                <td>{{ $post->category ? $post->category->name : 'N/A' }}</td>
                                <td>{{ $post->author ? $post->author->name : 'N/A' }}</td>
                                <td>{{ $post->created_at->format('d M Y') }}</td>
                                <td>
                                    <span class="badge me-4 bg-label-{{ $post->status == 'published' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </td>
                                @canany(['delete post', 'update post', 'view post'])
                                    <td class="d-flex">
                                        @canany(['delete post'])
                                            <form action="{{ route('dashboard.posts.destroy', $post->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <a href="#" type="submit"
                                                    class="btn btn-icon btn-text-danger waves-effect waves-light rounded-pill delete-record delete_confirmation"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('Delete Post') }}">
                                                    <i class="ti ti-trash ti-md"></i>
                                                </a>
                                            </form>
                                        @endcan
                                        @canany(['update post'])
                                            <span class="text-nowrap">
                                                <a href="{{ route('dashboard.posts.edit', $post->id) }}"
                                                    class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('Edit Post') }}">
                                                    <i class="ti ti-edit ti-md"></i>
                                                </a>
                                            </span>
                                            <span class="text-nowrap">
                                                <a href="{{ route('dashboard.posts.status.update', $post->id) }}"
                                                    class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ $post->status == 'published' ? __('Draft Post') : __('Publish Post') }}">
                                                    @if ($post->status == 'published')
                                                        <i class="ti ti-toggle-right ti-md text-success"></i>
                                                    @else
                                                        <i class="ti ti-toggle-left ti-md text-secondary"></i>
                                                    @endif
                                                </a>
                                            </span>
                                        @endcan
                                        {{-- @canany(['view post'])
                                            <span class="text-nowrap">
                                                <a href="{{ route('dashboard.blog-comments.index', $blog->id) }}"
                                                    class="btn btn-icon btn-text-warning waves-effect waves-light rounded-pill me-1"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="{{ __('View Comments') }}">
                                                    <i class="ti ti-message ti-md"></i>
                                                </a>
                                            </span>
                                        @endcan --}}
                                    </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            //
        });
    </script>
@endsection
