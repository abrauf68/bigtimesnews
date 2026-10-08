@extends('frontend.layouts.master')

@section('title', $page->meta_title)
@section('meta_title', $page->meta_title)
@section('meta_description', $page->meta_description)
@section('meta_keywords', $page->meta_keywords)
@section('author', $page->author)

@section('css')

@endsection

@section('breadcrumb-items')
@endsection

@section('content')
    @include('frontend.sections.top-posts')

    <!-- Featured Slider Section -->
    @include('frontend.sections.featured-slider')

    <!-- Featured Slider Section -->
    @include('frontend.sections.hot-now')

    @include('frontend.sections.category-sections-home')

    @include('frontend.sections.latest-news')

    @include('frontend.components.crawl-links', ['links' => $latestLinks ?? collect(), 'heading' => 'Latest articles'])
@endsection

@section('script')

@endsection
