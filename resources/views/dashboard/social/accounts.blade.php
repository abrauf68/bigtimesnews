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

        <p class="text-muted mb-4">{{ __('Only the platforms you enable below will receive auto-posted content. Everything, including API keys, is stored in the database — nothing needs to be set in .env.') }}</p>

        @foreach ($platforms as $platform)
            @php($account = $accounts->get($platform->value))
            @php($fields = config('social.credential_fields.' . $platform->value, []))
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">{{ $platform->label() }}</h5>
                        @if ($account && $account->display_name)
                            <div class="text-muted small">{{ $account->display_name }}</div>
                        @endif
                    </div>
                    <div class="d-flex align-items-center gap-2">
                        <span class="badge bg-label-{{ $account && $account->isConnected() ? 'success' : 'secondary' }}">
                            {{ $account && $account->isConnected() ? __('Connected') : __('Not connected') }}
                        </span>
                        @if ($account && $account->isConnected())
                            <span class="badge bg-label-{{ $account->isHealthy() ? 'success' : 'danger' }}">
                                {{ $account->isHealthy() ? __('Healthy') : __('Unhealthy') }}
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    @if ($account && $account->isConnected() && !$account->isHealthy() && $account->health_message)
                        <div class="alert alert-danger">{{ $account->health_message }}</div>
                    @endif

                    @if ($platform !== \App\Enums\SocialPlatform::Instagram)
                        <form action="{{ route('dashboard.social.credentials.update', $platform->value) }}" method="POST" class="row g-2 mb-3">
                            @csrf
                            <div class="col-md-4">
                                <label class="form-label">{{ __('Client ID / App ID') }}</label>
                                <input type="text" name="client_id" class="form-control" value="{{ $account->client_id ?? '' }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">{{ __('Client Secret / App Secret') }}</label>
                                <input type="password" name="client_secret" class="form-control" placeholder="{{ $account && $account->client_secret ? __('•••••••• (saved, leave blank to keep)') : '' }}">
                            </div>
                            @foreach ($fields as $key => $label)
                                <div class="col-md-4">
                                    <label class="form-label">{{ $label }}</label>
                                    <input type="text" name="settings[{{ $key }}]" class="form-control" value="{{ $account->settings[$key] ?? '' }}">
                                </div>
                            @endforeach
                            <div class="col-12">
                                <button type="submit" class="btn btn-sm btn-outline-primary mt-2">{{ __('Save Credentials') }}</button>
                            </div>
                        </form>
                    @else
                        <p class="text-muted">{{ __('Instagram reuses the Facebook App ID/Secret saved above — just connect below once a Facebook Page with a linked Instagram Business account is available.') }}</p>
                    @endif

                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        @if ($account && $account->isConnected())
                            <form action="{{ route('dashboard.social.toggle', $account->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm {{ $account->is_enabled ? 'btn-success' : 'btn-outline-secondary' }}">
                                    {{ $account->is_enabled ? __('Enabled — posts will be sent here') : __('Disabled — posts will be skipped') }}
                                </button>
                            </form>
                            <form action="{{ route('dashboard.social.disconnect', $account->id) }}" method="POST" onsubmit="return confirm('{{ __('Disconnect this account?') }}');">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Disconnect') }}</button>
                            </form>
                            @if ($account->token_expires_at)
                                <span class="text-muted small">{{ __('Token expires') }}: {{ $account->token_expires_at->format('d M Y, H:i') }}</span>
                            @endif
                        @else
                            <a href="{{ route('dashboard.social.connect', $platform->value) }}" class="btn btn-sm btn-primary">{{ __('Connect') }}</a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
