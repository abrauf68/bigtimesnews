@extends('frontend.pages.static.layout')

@section('title', 'All Articles')
@section('meta_title', 'All Articles | Big Times News')
@section('meta_description', 'Browse every article published on Big Times News, newest first.')
@section('meta_keywords', 'Big Times News articles, news archive')
@section('crumb', 'All Articles')
@section('heading', 'All Articles')
@section('lead', 'Every story published on Big Times News, newest first.')

@section('page_body')
    <ul>
        @foreach ($posts as $post)
            <li>
                <a href="{{ route('frontend.news.show', [$post->category->slug, $post->slug]) }}">{{ $post->title }}</a>
                <small>— {{ $post->category->name }}, {{ optional($post->published_at ?? $post->created_at)->format('M j, Y') }}</small>
            </li>
        @endforeach
    </ul>
    <nav aria-label="Pagination">
        @if ($posts->previousPageUrl()) <a rel="prev" href="{{ $posts->previousPageUrl() }}">&laquo; Newer</a> @endif
        <span>Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}</span>
        @if ($posts->nextPageUrl()) <a rel="next" href="{{ $posts->nextPageUrl() }}">Older &raquo;</a> @endif
    </nav>
@endsection
