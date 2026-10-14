@extends('frontend.pages.static.layout')

@php $company = \App\Helpers\Helper::getCompanyName(); @endphp
@section('title', $author->name)
@section('meta_title', $author->name . ' | Author at ' . $company)
@section('meta_description', \Illuminate\Support\Str::limit(trim(strip_tags($author->bio ?: ($author->name . ' writes for ' . $company . '. Read all articles by ' . $author->name . '.'))), 155, ''))
@section('meta_keywords', $author->name . ', ' . $company . ' author')
@section('crumb', $author->name)
@section('heading', $author->name)
@section('lead', 'Author at ' . $company)

@push('schema')
    @php
        $personSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'ProfilePage',
            'mainEntity' => array_filter([
                '@type' => 'Person',
                'name' => $author->name,
                'url' => $author->url,
                'description' => $author->bio ? trim(strip_tags($author->bio)) : null,
                'image' => $author->photo_url,
                'sameAs' => $author->same_as ?: null,
                'worksFor' => ['@type' => 'NewsMediaOrganization', 'name' => $company, 'url' => url('/')],
            ]),
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($personSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('page_body')
    <div style="display:flex;gap:1.25rem;align-items:flex-start;margin-bottom:1.5rem;">
        @include('frontend.components.author-avatar', ['author' => $author, 'size' => 88])
        <div>
            @if ($author->bio)
                <p style="margin:0 0 .75rem;">{{ $author->bio }}</p>
            @else
                <p style="margin:0 0 .75rem;">{{ $author->name }} writes for {{ $company }}.</p>
            @endif
            @if ($author->same_as)
                <p style="margin:0;">
                    @foreach ($author->same_as as $link)
                        <a href="{{ $link }}" rel="nofollow noopener" target="_blank" style="margin-right:1rem;">{{ parse_url($link, PHP_URL_HOST) }}</a>
                    @endforeach
                </p>
            @endif
        </div>
    </div>

    <h2>Articles by {{ $author->name }}</h2>
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
        @if ($posts->hasPages()) <span>Page {{ $posts->currentPage() }} of {{ $posts->lastPage() }}</span> @endif
        @if ($posts->nextPageUrl()) <a rel="next" href="{{ $posts->nextPageUrl() }}">Older &raquo;</a> @endif
    </nav>
@endsection
