@extends('layouts.master')

@section('title', __('AI Blog Custom Events'))

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.ai_blog.schedules.index') }}">{{ __('AI Blog Time Slots') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Custom Events') }}</li>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="alert alert-info">
            {{ __('US holidays and common events (Thanksgiving, Black Friday, Veterans Day, daylight saving time and more) are built in and their dates are calculated automatically. Add your own events here only if you want a post about a specific date. An event becomes eligible 3 to 42 days before its date, and each one produces 3 posts from different angles.') }}
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        <div class="card mb-4">
            <div class="card-header"><h5 class="mb-0">{{ __('Add an Event') }}</h5></div>
            <div class="card-body">
                <form action="{{ route('dashboard.ai_blog.events.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Event name') }}</label>
                        <input type="text" name="title" class="form-control" maxlength="120" placeholder="{{ __('e.g. National Pizza Day') }}" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{ __('Date') }}</label>
                        <input type="date" name="event_date" class="form-control" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">{{ __('Add') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table border-top">
                    <thead>
                        <tr>
                            <th>{{ __('Event') }}</th>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($events as $event)
                            <tr>
                                <td>{{ $event->title }}</td>
                                <td>{{ $event->event_date->format('D, M j, Y') }}</td>
                                <td>
                                    <span class="badge bg-label-{{ $event->is_active ? 'success' : 'secondary' }}">
                                        {{ $event->is_active ? __('Active') : __('Disabled') }}
                                    </span>
                                </td>
                                <td class="d-flex gap-2">
                                    <form action="{{ route('dashboard.ai_blog.events.toggle', $event->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-secondary">{{ $event->is_active ? __('Disable') : __('Enable') }}</button>
                                    </form>
                                    <form action="{{ route('dashboard.ai_blog.events.destroy', $event->id) }}" method="POST" onsubmit="return confirm('{{ __('Remove this event?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Remove') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">{{ __('No custom events yet.') }}</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
