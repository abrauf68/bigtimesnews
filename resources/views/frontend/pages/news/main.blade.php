@extends('frontend.layouts.master')

@section('title', $page->title)
@section('meta_title', $page->meta_title)
@section('meta_description', $page->meta_description)
@section('meta_keywords', $page->meta_keywords)
@section('author', $page->author)

@section('css')

@endsection

@section('breadcrumb-items')
@endsection

@section('content')
    <!-- Section start -->
    @if (isset($posts) && count($posts) > 0)
        <div class="block-slider block-slider-miniposts panel swiper-parent uc-dark">
            <div class="swiper-main swiper" data-uc-swiper="connect: .swiper-thumbs; items: 1; autoplay: 5000; active: 1; gap: 0; dots: .swiper-pagination; disable-class: opacity-30; effect: fade; fade: true;">
                <div class="swiper-wrapper">
                    @foreach ($posts as $post)
                        <div class="swiper-slide">
                            <article class="post type-post">
                                <figure hidden class="post-featured-image panel m-0">
                                    <canvas class="h-300px sm:h-400px lg:h-500px"></canvas>
                                    <img class="media-cover image" src="{{ $post->main_image ? asset($post->main_image) : asset('assets/img/blog/blog-default.png') }}" alt="Hidden Gems: Underrated Travel Destinations Around the World" data-uc-scrollspy="cls: uc-animation-kenburns; repeat: true">
                                    <a href="{{ route('frontend.news.show', [$post->category->slug, $post->slug]) }}" class="position-cover"></a>
                                </figure>
                                <div class="featured-image bg-gray-25 dark:bg-gray-800">
                                    <canvas class="min-h-300px lg:min-h-500px"></canvas>
                                    <img class="media-cover image" src="{{ asset('assets/img/blog/blog-default.png') }}" data-src="{{ $post->main_image ? asset($post->main_image) : asset('assets/img/blog/blog-default.png') }}" alt="Hidden Gems: Underrated Travel Destinations Around the World" data-uc-img="loading: lazy">
                                </div>
                                <div class="d-block position-cover bg-gradient-to-r from-black to-transparent z-1 opacity-60"></div>
                                <div class="panel max-w-xl mx-auto px-2 z-3">
                                    <div class="post-header panel position-absolute bottom-0 vstack justify-between gap-2 xl:gap-4 max-w-600px mb-4 xl:mb-8">
                                        <div class="post-top hstack gap-narrow">
                                            <div class="post-category hstack gap-narrow fs-7 fw-bold h-24px px-1 rounded-1 shadow-xs bg-white text-primary">
                                                <a class="text-none" href="{{ route('frontend.news.category', $post->category->slug) }}">{{ $post->category->name ?? 'Uncategorized' }}</a>
                                            </div>
                                        </div>
                                        <h3 class="post-title h4 lg:h3 xl:h2 m-0 text-truncate-2" data-swiper-parallax="-48">
                                            <a class="text-none" href="{{ route('frontend.news.show', [$post->category->slug, $post->slug]) }}">{{ $post->title }}</a>
                                        </h3>
                                        <div>
                                            <div class="post-meta panel hstack justify-between fs-7 fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                <div class="meta">
                                                    <div class="hstack gap-2">
                                                        <div>
                                                            <div class="post-author hstack gap-1">
                                                                <span>By</span>
                                                                <a href="#" class="text-black dark:text-white text-none fw-bold">{{ $post->author ? $post->author->name : 'Unknown Author' }}</a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-date hstack gap-narrow">
                                                                <span>{{ $post->published_at->format('M d, Y') }}</span>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <a href="#post_comment" class="post-comments text-none hstack gap-narrow">
                                                                <i class="icon-narrow unicon-chat"></i>
                                                                <span>{{ $post->comment_count ?? 0 }}</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="actions">
                                                    <div class="hstack gap-1"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @endforeach
                </div>

                <!-- Add Arrows -->
                <div class="swiper-navigation position-cover panel max-w-xl mx-auto px-2 mt-2 xl:mt-8">
                    <div class="hstack justify-end md:justify-start gap-1">
                        <div class="swiper-nav swiper-prev btn w-40px lg:w-48px h-40px lg:h-48px p-0 border-0 bg-white bg-opacity-30 hover:bg-primary hover:bg-opacity-100 text-white rounded-circle shadow-xs z-1">
                            <i class="unicon-chevron-left icon-1"></i>
                        </div>
                        <div class="swiper-nav swiper-next btn w-40px lg:w-48px h-40px lg:h-48px p-0 border-0 bg-white bg-opacity-30 hover:bg-primary hover:bg-opacity-100 text-white rounded-circle shadow-xs z-1">
                            <i class="unicon-chevron-right icon-1"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="position-absolute top-0 end-0 bottom-0 w-1/2 bg-gradient-to-l from-black to-transparent opacity-70 z-1 d-none lg:d-block"></div>
            <div class="slider-thumbs-wrap d-none lg:d-block">
                <div class="container container-2xl">
                    <div class="panel">
                        <div class="swiper swiper-thumbs position-absolute end-0 bottom-0 max-h-300px max-w-300px mb-4 xl:mb-8 z-2" data-uc-swiper="items: 3; gap: 16; direction: vertical; mousewheel: true; freeMode: true;">
                            <div class="swiper-wrapper">
                                @foreach ($posts as $post)
                                    <div class="swiper-slide">
                                        <article class="post type-post">
                                            <div class="post-header panel vstack justify-between gap-1 lg:gap-2">
                                                <div>
                                                    <div class="post-meta panel hstack justify-between fs-7 fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                        <div class="meta">
                                                            <div class="hstack gap-2">
                                                                <div>
                                                                    <div class="post-date hstack gap-narrow">
                                                                        <span>{{ $post->published_at->format('M d, Y') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="actions">
                                                            <div class="hstack gap-1"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h3 class="h6 m-0 text-truncate-2">{{ $post->title }}</h3>
                                            </div>
                                        </article>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Section end -->

    <!-- Section start -->
    <div class="section panel overflow-hidden">
        <div class="section-outer panel pt-5 lg:pt-8">
            <div class="container max-w-xl">
                <div class="section-inner">
                    <a class="text-none" href="https://themeforest.net/user/reacthemes/portfolio" target="_blank" rel="nofollow">
                        <img class="d-none md:d-block" src="{{ asset('front/images/common/ad-slot.jpg') }}" alt="Ad slot">
                        <img class="d-block md:d-none" src="{{ asset('front/images/common/ad-slot-mobile.jpg') }}" alt="Ad slot">
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Section start -->
    @include('frontend.sections.category-posts')
    <!-- Section end -->

    <!-- Section start -->
    <div class="section panel overflow-hidden">
        <div class="section-outer panel pt-5 lg:pt-8">
            <div class="container max-w-xl">
                <div class="section-inner">
                    <a class="text-none" href="https://themeforest.net/user/reacthemes/portfolio" target="_blank" rel="nofollow">
                        <img class="d-none md:d-block" src="{{ asset('front/images/common/ad-slot-2.jpg') }}" alt="Ad slot">
                        <img class="d-block md:d-none" src="{{ asset('front/images/common/ad-slot-mobile-2.jpg') }}" alt="Ad slot">
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Section start -->
@endsection

@section('script')

@endsection
