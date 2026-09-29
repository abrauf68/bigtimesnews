@extends('layouts.master')

@section('title', __('Social Publishing'))

@section('breadcrumb-items')
    <li class="breadcrumb-item active">{{ __('Social Publishing') }}</li>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex mb-4 gap-2">
            <a href="{{ route('dashboard.social.index') }}" class="btn btn-primary">{{ __('Accounts') }}</a>
            <a href="{{ route('dashboard.social.posts.index') }}" class="btn btn-outline-primary">{{ __('Post Status') }}</a>
            <a href="{{ route('dashboard.social.subreddits.index') }}" class="btn btn-outline-primary">{{ __('Reddit Subreddits') }}</a>
        </div>

        <div class="card">
            <div class="card-datatable table-responsive">
                <table class="table border-top">
                    <thead>
                        <tr>
                            <th>{{ __('Platform') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Health') }}</th>
                            <th>{{ __('Token Expiry') }}</th>
                            <th>{{ __('Enabled') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($platforms as $platform)
                            @php($account = $accounts->get($platform->value))
                            <tr>
                                <td><strong>{{ $platform->label() }}</strong>
                                    @if ($account && $account->display_name)
                                        <div class="text-muted small">{{ $account->display_name }}</div>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-label-{{ $account && $account->isConnected() ? 'success' : 'secondary' }}">
                                        {{ $account && $account->isConnected() ? __('Connected') : __('Not connected') }}
                                    </span>
                                </td>
                                <td>
                                    @if ($account && $account->isConnected())
                                        <span class="badge bg-label-{{ $account->isHealthy() ? 'success' : 'danger' }}">
                                            {{ $account->isHealthy() ? __('Healthy') : __('Unhealthy') }}
                                        </span>
                                        @if (!$account->isHealthy() && $account->health_message)
                                            <div class="text-danger small">{{ $account->health_message }}</div>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($account && $account->token_expires_at)
                                        <span class="{{ $account->isTokenExpiringSoon(1440) ? 'text-danger' : '' }}">
                                            {{ $account->token_expires_at->format('d M Y, H:i') }}
                                        </span>
                                    @else
                                        <span class="text-muted">{{ __('N/A') }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($account && $account->isConnected())
                                        <form action="{{ route('dashboard.social.toggle', $account->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm {{ $account->is_enabled ? 'btn-success' : 'btn-outline-secondary' }}">
                                                {{ $account->is_enabled ? __('Enabled') : __('Disabled') }}
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($account && $account->isConnected())
                                        <form action="{{ route('dashboard.social.disconnect', $account->id) }}" method="POST" onsubmit="return confirm('{{ __('Disconnect this account?') }}');">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Disconnect') }}</button>
                                        </form>
                                    @else
                                        <a href="{{ route('dashboard.social.connect', $platform->value) }}" class="btn btn-sm btn-primary">{{ __('Connect') }}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
