@extends('layouts.mails.master')

@section('title', $autoPublished ? 'AI Blog Posts Published' : 'AI Blog Drafts Ready')

@section('css')
@endsection

@section('content')
    <p>{{ __('Hi') }},</p>

    @if ($autoPublished)
        <p>{{ __('Your AI Blog Automation just published :count new post(s) on the site.', ['count' => $completed->count()]) }}</p>
    @else
        <p>{{ __('Your AI Blog Automation generated :count new post(s) and saved them as drafts. Please review before publishing.', ['count' => $completed->count()]) }}</p>
    @endif

    @if ($completed->count())
        <div class="credentials">
            <h3>{{ __('Generated Posts:') }}</h3>
            <ul>
                @foreach ($completed as $post)
                    <p>
                        <strong>{{ $post->title }}</strong><br>
                        {{ __('Status') }}: {{ ucfirst($post->status) }} &middot;
                        {{ __('Category') }}: {{ $post->category->name ?? 'N/A' }}<br>
                        <a href="{{ route('dashboard.posts.edit', $post->id) }}">{{ __('Review / Edit this post') }}</a>
                    </p>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($failed->count())
        <div class="credentials">
            <h3>{{ __('Topics that failed to generate:') }}</h3>
            <ul>
                @foreach ($failed as $topic)
                    <p>
                        <strong>{{ $topic->topic }}</strong><br>
                        <span style="color:#d9534f;">{{ $topic->error_message }}</span>
                    </p>
                @endforeach
            </ul>
        </div>
    @endif

    <a href="{{ route('dashboard.posts.index') }}" class="cta-button">{{ __('View All Posts') }}</a>
@endsection

@section('script')
@endsection
