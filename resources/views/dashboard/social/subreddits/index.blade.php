@extends('layouts.master')

@section('title', __('Reddit Subreddits'))

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.social.index') }}">{{ __('Social Publishing') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Reddit Subreddits') }}</li>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex mb-4 gap-2">
            <a href="{{ route('dashboard.social.index') }}" class="btn btn-outline-primary">{{ __('Accounts') }}</a>
            <a href="{{ route('dashboard.social.posts.index') }}" class="btn btn-outline-primary">{{ __('Post Status') }}</a>
            <a href="{{ route('dashboard.social.subreddits.index') }}" class="btn btn-primary">{{ __('Reddit Subreddits') }}</a>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h5 class="mb-3">{{ __('Add a subreddit') }}</h5>
                <p class="text-muted">{{ __('Posts are only submitted to subreddits an admin has explicitly approved below. Newly added subreddits are pending until approved.') }}</p>
                <form action="{{ route('dashboard.social.subreddits.store') }}" method="POST" class="row g-2">
                    @csrf
                    <div class="col-md-4">
                        <input type="text" name="name" class="form-control" placeholder="{{ __('e.g. technology') }}" required>
                    </div>
                    <div class="col-md-4">
                        <select name="category_id" class="form-select">
                            <option value="">{{ __('Any category') }}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
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
                            <th>{{ __('Subreddit') }}</th>
                            <th>{{ __('Category') }}</th>
                            <th>{{ __('Approved') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($subreddits as $subreddit)
                            <tr>
                                <td>r/{{ $subreddit->name }}</td>
                                <td>{{ $subreddit->category->name ?? __('Any') }}</td>
                                <td>
                                    <span class="badge bg-label-{{ $subreddit->is_approved ? 'success' : 'warning' }}">
                                        {{ $subreddit->is_approved ? __('Approved') : __('Pending approval') }}
                                    </span>
                                </td>
                                <td class="d-flex gap-2">
                                    @unless ($subreddit->is_approved)
                                        <form action="{{ route('dashboard.social.subreddits.approve', $subreddit->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">{{ __('Approve') }}</button>
                                        </form>
                                    @endunless
                                    <form action="{{ route('dashboard.social.subreddits.destroy', $subreddit->id) }}" method="POST" onsubmit="return confirm('{{ __('Remove this subreddit?') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('Remove') }}</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">{{ __('No subreddits configured yet. Reddit posting is skipped until at least one is approved.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
