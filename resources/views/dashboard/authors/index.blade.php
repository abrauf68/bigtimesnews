@extends('layouts.master')

@section('title', __('Authors'))

@section('css')
@endsection


@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Authors') }}</li>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Authors List Table -->
        <div class="card">
            <div class="card-header">
                @canany(['create category'])
                    <a href="{{route('dashboard.authors.create')}}" class="add-new btn btn-primary waves-effect waves-light">
                        <i class="ti ti-plus me-0 me-sm-1 ti-xs"></i><span
                            class="d-none d-sm-inline-block">{{ __('Add New Author') }}</span>
                    </a>
                @endcan
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table border-top custom-datatables">
                    <thead>
                        <tr>
                            <th>{{ __('Sr.') }}</th>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Image') }}</th>
                            <th>{{ __('Status') }}</th>
                            @canany(['delete author', 'update author'])<th>{{ __('Action') }}</th>@endcan
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($authors as $index => $author)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $author->name }}</td>
                                <td>
                                    @if (isset($author->image))
                                        <img src="{{ asset($author->image) }}" alt="{{ $author->name }}"
                                            height="35px" width="35px">
                                    @else
                                        {{ __('No Image') }}
                                    @endif
                                </td>
                                <td>
                                    <span
                                        class="badge me-4 bg-label-{{ $author->is_active == 'active' ? 'success' : 'danger' }}">{{ ucfirst($author->is_active) }}</span>
                                </td>
                                @canany(['delete author', 'update author'])
                                    <td class="d-flex">
                                        @canany(['delete author'])
                                            <form action="{{ route('dashboard.authors.destroy', $author->id) }}" method="POST">
                                                @method('DELETE')
                                                @csrf
                                                <a href="#" type="submit"
                                                    class="btn btn-icon btn-text-danger waves-effect waves-light rounded-pill delete-record delete_confirmation"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('Delete Author') }}">
                                                    <i class="ti ti-trash ti-md"></i>
                                                </a>
                                            </form>
                                        @endcan
                                        @canany(['update author'])
                                            <span class="text-nowrap">
                                                <a href="{{ route('dashboard.authors.edit', $author->id) }}"
                                                    class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ __('Edit Author') }}">
                                                    <i class="ti ti-edit ti-md"></i>
                                                </a>
                                            </span>
                                            <span class="text-nowrap">
                                                <a href="{{ route('dashboard.authors.status.update', $author->id) }}"
                                                    class="btn btn-icon btn-text-primary waves-effect waves-light rounded-pill me-1"
                                                    data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="{{ $author->is_active == 'active' ? __('Deactivate Author') : __('Activate Author') }}">
                                                    @if ($author->is_active == 'active')
                                                        <i class="ti ti-toggle-right ti-md text-success"></i>
                                                    @else
                                                        <i class="ti ti-toggle-left ti-md text-danger"></i>
                                                    @endif
                                                </a>
                                            </span>
                                        @endcan
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
    {{-- <script src="{{asset('assets/js/app-user-list.js')}}"></script> --}}
    <script>
        $(document).ready(function() {
            //
        });
    </script>
@endsection
