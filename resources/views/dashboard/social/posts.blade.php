@extends('layouts.master')

@section('title', __('Social Post Status'))

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.social.index') }}">{{ __('Social Publishing') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Post Status') }}</li>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex mb-4 gap-2">
            <a href="{{ route('dashboard.social.index') }}" class="btn btn-outline-primary">{{ __('Accounts') }}</a>
            <a href="{{ route('dashboard.social.posts.index') }}" class="btn btn-primary">{{ __('Post Status') }}</a>
            <a href="{{ route('dashboard.social.subreddits.index') }}" class="btn btn-outline-primary">{{ __('Reddit Subreddits') }}</a>
        </div>

        <form method="GET" class="row g-2 mb-4">
            <div class="col-auto">
                <select name="platform" class="form-select" onchange="this.form.submit()">
                    <option value="">{{ __('All Platforms') }}</option>
                    @foreach ($platforms as $platform)
                        <option value="{{ $platform->value }}" @selected(request('platform') === $platform->value)>{{ $platform->label() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-auto">
                <select name="status" class="form-select" onchange="this.form.submit()">
                    <option value="">{{ __('All Statuses') }}</option>
                    @foreach (['pending', 'queued', 'posted', 'failed', 'skipped'] as $status)
                        <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
            </div>
        </form>

        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table border-top">
                    <thead>
                        <tr>
                            <th>{{ __('Post') }}</th>
                            <th>{{ __('Platform') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Caption') }}</th>
                            <th>{{ __('Reason') }}</th>
                            <th>{{ __('Link') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($targets as $target)
                            <tr>
                                <td>
                                    @if ($target->post)
                                        <a href="{{ route('dashboard.posts.edit', $target->post->id) }}">{{ \Illuminate\Support\Str::limit($target->post->title, 40) }}</a>
                                    @else
                                        <span class="text-muted">{{ __('Deleted post') }}</span>
                                    @endif
                                </td>
                                <td>{{ $target->platformEnum()->label() }}</td>
                                <td>
                                    <span class="badge bg-label-{{ $target->status === 'posted' ? 'success' : ($target->status === 'failed' ? 'danger' : ($target->status === 'skipped' ? 'warning' : 'secondary')) }}">
                                        {{ ucfirst($target->status) }}
                                    </span>
                                </td>
                                <td style="max-width:260px;">
                                    <form action="{{ route('dashboard.social.targets.caption', $target->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        @if ($target->caption_title !== null)
                                            <input type="text" name="caption_title" class="form-control form-control-sm mb-1" value="{{ $target->caption_title }}" placeholder="{{ __('Title') }}">
                                        @endif
                                        <textarea name="caption" class="form-control form-control-sm mb-1" rows="2">{{ $target->caption }}</textarea>
                                        <button type="submit" class="btn btn-xs btn-outline-primary" {{ $target->status === 'posted' ? 'disabled' : '' }}>{{ __('Save Caption') }}</button>
                                    </form>
                                </td>
                                <td class="small text-muted" style="max-width:200px;">{{ $target->skip_reason ?: $target->error_message }}</td>
                                <td>
                                    @if ($target->external_post_url)
                                        <a href="{{ $target->external_post_url }}" target="_blank" rel="noopener">{{ __('View') }}</a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($target->isRetryable())
                                        <form action="{{ route('dashboard.social.targets.retry', $target->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-primary">{{ __('Retry') }}</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">{{ __('No social publishing activity yet.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">
                <div class="text-muted small">
                    {{ __('Showing :from to :to of :total results', [
                        'from' => $targets->firstItem() ?? 0,
                        'to' => $targets->lastItem() ?? 0,
                        'total' => $targets->total(),
                    ]) }}
                </div>
                {{ $targets->onEachSide(1)->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection
