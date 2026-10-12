@extends('layouts.master')

@section('title', __('AI Blog Time Slots'))

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('AI Blog Time Slots') }}</li>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="alert alert-info">
            {{ __('Instead of generating all daily posts at once, add multiple time slots below. Each slot runs independently, once per day, at its own time. Choose how many Trend, Upcoming date and Evergreen posts each slot should write (and optionally its own country/category focus). If no time slots are added here, the single "Daily Run Time" / "Blogs Per Day" fields on the AI Blog settings page are used as a fallback.') }}
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif

        @php($dailyTotal = $schedules->where('is_enabled', true)->sum(fn ($s) => $s->totalPosts()))
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-2">
            <div>
                <span class="badge bg-label-primary me-1">{{ __('Trend') }}: {{ $schedules->where('is_enabled', true)->sum('trend_count') }}</span>
                <span class="badge bg-label-warning me-1">{{ __('Upcoming') }}: {{ $schedules->where('is_enabled', true)->sum('upcoming_count') }}</span>
                <span class="badge bg-label-success me-1">{{ __('Evergreen') }}: {{ $schedules->where('is_enabled', true)->sum('evergreen_count') }}</span>
                <strong>{{ __('Total per day') }}: {{ $dailyTotal }}</strong>
            </div>
            <a href="{{ route('dashboard.ai_blog.events.index') }}" class="btn btn-outline-primary btn-sm">{{ __('Manage custom events') }}</a>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">{{ __('Add a Time Slot') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('dashboard.ai_blog.schedules.store') }}" method="POST" class="row g-3">
                    @csrf
                    <div class="col-md-2">
                        <label class="form-label">{{ __('Run Time') }}</label>
                        <input type="time" name="run_time" class="form-control" required>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">{{ __('Trend') }}</label>
                        <input type="number" name="trend_count" min="0" max="20" value="1" class="form-control" required>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">{{ __('Upcoming') }}</label>
                        <input type="number" name="upcoming_count" min="0" max="20" value="0" class="form-control" required>
                    </div>
                    <div class="col-md-1">
                        <label class="form-label">{{ __('Evergreen') }}</label>
                        <input type="number" name="evergreen_count" min="0" max="20" value="1" class="form-control" required>
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
                        <label class="form-label">{{ __('Trend country (optional)') }}</label>
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
                            <th>{{ __('Trend') }}</th>
                            <th>{{ __('Upcoming') }}</th>
                            <th>{{ __('Evergreen') }}</th>
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
                                @php($counts = $schedule->countsByType())
                                <td style="width:80px;">
                                    <input form="scheduleForm{{ $schedule->id }}" type="number" name="trend_count" min="0" max="20" class="form-control form-control-sm" value="{{ $counts['trend'] }}" required>
                                </td>
                                <td style="width:80px;">
                                    <input form="scheduleForm{{ $schedule->id }}" type="number" name="upcoming_count" min="0" max="20" class="form-control form-control-sm" value="{{ $counts['upcoming'] }}" required>
                                </td>
                                <td style="width:80px;">
                                    <input form="scheduleForm{{ $schedule->id }}" type="number" name="evergreen_count" min="0" max="20" class="form-control form-control-sm" value="{{ $counts['evergreen'] }}" required>
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
                                <td colspan="9" class="text-center text-muted">{{ __('No time slots configured yet — the legacy single daily run time is being used.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
