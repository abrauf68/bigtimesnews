@extends('layouts.master')

@section('title', __('AI Blog Time Slots'))

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('AI Blog Time Slots') }}</li>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="alert alert-info">
            {{ __('Instead of generating all daily posts at once, add multiple time slots below. Each slot runs independently, once per day, at its own time, with its own post count and (optionally) its own country/category focus. If no time slots are added here, the single "Daily Run Time" / "Blogs Per Day" fields on the AI Blog settings page are used as a fallback.') }}
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Add a Time Slot') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.ai_blog.schedules.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Run Time') }}</label>
                        <input type="time" name="run_time" class="form-control" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">{{ __('Posts') }}</label>
                        <input type="number" name="post_count" min="1" max="20" value="1" class="form-control" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">{{ __('Category (optional)') }}</label>
                        <select name="category_id" class="form-select">
                            <option value="">{{ __('Auto-detect (default)') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">{{ __('Country (optional)') }}</label>
                        <input type="text" name="trend_country" class="form-control" placeholder="{{ __('e.g. US') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">{{ __('Add Slot') }}</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table border-top">
                    <thead>
                        <tr>
                            <th>{{ __('Time') }}</th>
                            <th>{{ __('Posts') }}</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Country') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Last Run') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($schedules as $schedule)
                            <form id="scheduleForm{{ $schedule->id }}" action="{{ route('dashboard.ai_blog.schedules.update', $schedule->id) }}" method="POST" class="d-none">
                                @csrf
                                @method('PUT')
                            </form>
                            <tr>
                                <td style="width:110px;">
                                    <input form="scheduleForm{{ $schedule->id }}" type="time" name="run_time" class="form-control form-control-sm" value="{{ $schedule->formattedTime() }}" required>
                                </td>
                                <td style="width:90px;">
                                    <input form="scheduleForm{{ $schedule->id }}" type="number" name="post_count" min="1" max="20" class="form-control form-control-sm" value="{{ $schedule->post_count }}" required>
                                </td>
                                <td style="width:180px;">
                                    <select form="scheduleForm{{ $schedule->id }}" name="category_id" class="form-select form-select-sm">
                                        <option value="">{{ __('Auto-detect') }}</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" @selected($schedule->category_id === $category->id)>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td style="width:110px;">
                                    <input form="scheduleForm{{ $schedule->id }}" type="text" name="trend_country" class="form-control form-control-sm" value="{{ $schedule->trend_country }}">
                                </td>
                                <td>
                                    <span class="badge bg-label-{{ $schedule->is_enabled ? 'success' : 'secondary' }}">
                                        {{ $schedule->is_enabled ? __('Enabled') : __('Disabled') }}
                                    </span>
                                    @if ($schedule->hasRunToday())
                                        <span class="badge bg-label-info">{{ __('Ran today') }}</span>
                                    @endif
                                </td>
                                <td class="small text-muted">{{ $schedule->last_run_summary ?: __('Never') }}</td>
                                <td class="d-flex gap-2">
                                    <button form="scheduleForm{{ $schedule->id }}" type="submit" class="btn btn-sm btn-outline-primary">{{ __('Save') }}</button>
                                    <form action="{{ route('dashboard.ai_blog.schedules.toggle', $schedule->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm {{ $schedule->is_enabled ? 'btn-outline-secondary' : 'btn-outline-success' }}">
                                            {{ $schedule->is_enabled ? __('Disable') : __('Enable') }}
                                        </button>
                                    </form>
                                    <form action="{{ route('dashboard.ai_blog.schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('{{ __('Remove this time slot?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Remove') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">{{ __('No time slots configured yet — the legacy single daily run time is being used.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
