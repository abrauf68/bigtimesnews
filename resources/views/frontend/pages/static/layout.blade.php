@extends('frontend.layouts.master')

@section('author', config('site.name'))

@push('schema')
    @php
        $crumbSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => route('frontend.home')],
                ['@type' => 'ListItem', 'position' => 2, 'name' => trim($__env->yieldContent('crumb')), 'item' => url()->current()],
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($crumbSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('css')
<style>
    .static-page { --sp-text:#1f2937; --sp-head:#111827; --sp-muted:#6b7280; --sp-border:#e5e7eb; --sp-soft:#f9fafb; }
    html.uc-dark .static-page { --sp-text:#d1d5db; --sp-head:#ffffff; --sp-muted:#9ca3af; --sp-border:#374151; --sp-soft:#1f2937; }
    .static-page .sp-wrap { max-width: 820px; margin: 0 auto; }
    .static-page .sp-breadcrumb { font-size: .875rem; color: var(--sp-muted); margin-bottom: 1rem; }
    .static-page .sp-breadcrumb a { color: var(--sp-muted); text-decoration: none; }
    .static-page .sp-breadcrumb a:hover { text-decoration: underline; }
    .static-page h1 { color: var(--sp-head); font-size: clamp(1.9rem, 4vw, 2.6rem); line-height: 1.2; margin: 0 0 .75rem; }
    .static-page .sp-lead { color: var(--sp-text); font-size: 1.15rem; line-height: 1.7; margin-bottom: .75rem; }
    .static-page .sp-updated { color: var(--sp-muted); font-size: .875rem; margin-bottom: 2rem; }
    .static-page .sp-content { color: var(--sp-text); font-size: 1.05rem; line-height: 1.8; }
    .static-page .sp-content h2 { color: var(--sp-head); font-size: 1.5rem; margin: 2.25rem 0 .75rem; padding-top: .25rem; scroll-margin-top: 100px; }
    .static-page .sp-content h3 { color: var(--sp-head); font-size: 1.15rem; margin: 1.5rem 0 .5rem; }
    .static-page .sp-content p { color: var(--sp-text); margin: 0 0 1rem; }
    .static-page .sp-content ul, .static-page .sp-content ol { color: var(--sp-text); margin: 0 0 1.25rem 1.25rem; padding-left: .75rem; }
    .static-page .sp-content ul { list-style: disc; }
    .static-page .sp-content ol { list-style: decimal; }
    .static-page .sp-content li { color: var(--sp-text); margin-bottom: .4rem; }
    .static-page .sp-content a { color: #2757fd; text-decoration: underline; }
    .static-page .sp-content strong { color: var(--sp-head); }
    .static-page .sp-toc { background: var(--sp-soft); border: 1px solid var(--sp-border); border-radius: 10px; padding: 1rem 1.25rem; margin-bottom: 2rem; }
    .static-page .sp-toc strong { display:block; margin-bottom:.5rem; color: var(--sp-head); }
    .static-page .sp-toc ol { margin: 0 0 0 1.1rem; padding: 0; list-style: decimal; font-size: .95rem; columns: 2; column-gap: 2rem; }
    .static-page .sp-toc a { color: #2757fd; text-decoration: none; }
    .static-page .sp-toc a:hover { text-decoration: underline; }
    .static-page .sp-card { background: var(--sp-soft); border: 1px solid var(--sp-border); border-radius: 12px; padding: 1.25rem 1.5rem; margin: 1.25rem 0; }
    .static-page .sp-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: .75rem; margin: 1rem 0 1.5rem; }
    .static-page .sp-grid a { display:block; padding: .7rem 1rem; border: 1px solid var(--sp-border); border-radius: 8px; color: var(--sp-head) !important; text-decoration: none !important; font-weight: 600; background: var(--sp-soft); }
    .static-page .sp-grid a:hover { border-color: #2757fd; }
    .static-page .sp-related { margin-top: 3rem; padding-top: 1.5rem; border-top: 1px solid var(--sp-border); font-size: .95rem; color: var(--sp-muted); }
    .static-page .sp-related a { color: #2757fd; margin-right: 1rem; }
    @media (max-width: 640px) { .static-page .sp-toc ol { columns: 1; } }
</style>
@yield('page_css')
@endsection

@section('content')
<div class="static-page panel py-6 lg:py-9">
    <div class="container max-w-xl">
        <div class="sp-wrap">
            <nav class="sp-breadcrumb" aria-label="Breadcrumb">
                <a href="{{ route('frontend.home') }}">Home</a> &rsaquo; <span>@yield('crumb')</span>
            </nav>

            <h1>@yield('heading')</h1>
            @hasSection('lead')
                <p class="sp-lead">@yield('lead')</p>
            @endif
            @hasSection('updated')
                <p class="sp-updated">@yield('updated')</p>
            @endif

            <div class="sp-content">
                @yield('page_body')
            </div>

            <div class="sp-related">
                <a href="{{ route('frontend.about') }}">About Us</a>
                <a href="{{ route('frontend.contact') }}">Contact</a>
                <a href="{{ route('frontend.privacy') }}">Privacy Policy</a>
                <a href="{{ route('frontend.terms') }}">Terms of Service</a>
            </div>
        </div>
    </div>
</div>
@endsection
