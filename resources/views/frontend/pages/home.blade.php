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
    <div class="section panel overflow-hidden swiper-parent border-top">
        <div class="section-outer panel py-2 lg:py-4 dark:text-white">
            <div class="container max-w-xl">
                <div class="section-inner panel vstack gap-2">
                    <div class="block-layout carousel-layout vstack gap-2 lg:gap-3 panel">
                        <div class="block-content panel">
                            <div class="swiper"
                                data-uc-swiper="items: 1; gap: 16; dots: .dot-nav; next: .nav-next; prev: .nav-prev; disable-class: d-none;"
                                data-uc-swiper-s="items: 3; gap: 24;" data-uc-swiper-l="items: 4; gap: 24;">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle gap-2">
                                                <div class="row child-cols g-2" data-uc-grid>
                                                    <div class="col-auto">
                                                        <div class="post-media panel overflow-hidden max-w-64px min-w-64px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-09.jpg"
                                                                    alt="Hidden Gems: Underrated Travel Destinations Around the World"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">Hidden Gems: Underrated Travel
                                                                    Destinations Around the World</a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle gap-2">
                                                <div class="row child-cols g-2" data-uc-grid>
                                                    <div class="col-auto">
                                                        <div class="post-media panel overflow-hidden max-w-64px min-w-64px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-10.jpg"
                                                                    alt="Eco-Tourism: Traveling Responsibly and Sustainably"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">Eco-Tourism: Traveling
                                                                    Responsibly and Sustainably</a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle gap-2">
                                                <div class="row child-cols g-2" data-uc-grid>
                                                    <div class="col-auto">
                                                        <div class="post-media panel overflow-hidden max-w-64px min-w-64px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-11.jpg"
                                                                    alt="Solo Travel: Some Tips and Destinations for the Adventurous Explorer"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">Solo Travel: Some Tips and
                                                                    Destinations for the Adventurous Explorer</a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle gap-2">
                                                <div class="row child-cols g-2" data-uc-grid>
                                                    <div class="col-auto">
                                                        <div class="post-media panel overflow-hidden max-w-64px min-w-64px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-12.jpg"
                                                                    alt="AI-Powered Financial Planning: How Algorithms Revolutionizing"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">AI-Powered Financial Planning:
                                                                    How Algorithms Revolutionizing</a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle gap-2">
                                                <div class="row child-cols g-2" data-uc-grid>
                                                    <div class="col-auto">
                                                        <div class="post-media panel overflow-hidden max-w-64px min-w-64px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-13.jpg"
                                                                    alt="Tech Tools for your Time Management: Enhancing Productivity"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">Tech Tools for your Time
                                                                    Management: Enhancing Productivity</a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle gap-2">
                                                <div class="row child-cols g-2" data-uc-grid>
                                                    <div class="col-auto">
                                                        <div
                                                            class="post-media panel overflow-hidden max-w-64px min-w-64px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-14.jpg"
                                                                    alt="A Guide to The Rise of Gourmet Street Food: Trends and Top Picks"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">A Guide to The Rise of Gourmet
                                                                    Street Food: Trends and Top Picks</a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle gap-2">
                                                <div class="row child-cols g-2" data-uc-grid>
                                                    <div class="col-auto">
                                                        <div
                                                            class="post-media panel overflow-hidden max-w-64px min-w-64px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-15.jpg"
                                                                    alt="Gaming in the Age of AI: Strategies for Startups"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">Gaming in the Age of AI:
                                                                    Strategies for Startups</a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle gap-2">
                                                <div class="row child-cols g-2" data-uc-grid>
                                                    <div class="col-auto">
                                                        <div
                                                            class="post-media panel overflow-hidden max-w-64px min-w-64px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-16.jpg"
                                                                    alt="Top Independent Contractors to Invest in Best of Startups"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">Top Independent Contractors to
                                                                    Invest in Best of Startups</a>
                                                            </h3>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="swiper-nav nav-prev position-absolute top-50 start-0 translate-middle btn btn-alt-primary text-black rounded-circle p-0 border shadow-xs w-32px h-32px z-1">
                                <i class="icon-1 unicon-chevron-left"></i>
                            </div>
                            <div
                                class="swiper-nav nav-next position-absolute top-50 start-100 translate-middle btn btn-alt-primary text-black rounded-circle p-0 border shadow-xs w-32px h-32px z-1">
                                <i class="icon-1 unicon-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Section end -->

    <!-- Section start -->
    <div class="section panel mb-4 lg:mb-6">
        <div class="section-outer panel">
            <div class="container max-w-xl">
                <div class="section-inner panel vstack gap-4">
                    <div class="section-content">
                        <div class="row child-col-12 lg:child-cols g-4 lg:g-6 col-match">
                            <div class="lg:col-9">
                                <div class="block-layout slider-layout swiper-parent uc-dark">
                                    <div class="block-content panel uc-visible-toggle">
                                        <div class="swiper"
                                            data-uc-swiper="items: 1; active: 1; gap: 4; prev: .nav-prev; next: .nav-next; autoplay: 6000; parallax: true; fade: true; effect: fade; disable-class: d-none;">
                                            <div class="swiper-wrapper">
                                                <div class="swiper-slide">
                                                    <article
                                                        class="post type-post panel uc-transition-toggle vstack gap-2 lg:gap-3 h-100 overflow-hidden uc-dark">
                                                        <div class="post-media panel overflow-hidden h-100">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 h-100 d-none md:d-block">
                                                                <canvas class="h-100 w-100"></canvas>
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-11.jpg"
                                                                    alt="Solo Travel: Some Tips and Destinations for the Adventurous Explorer"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-16x9 d-block md:d-none">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-11.jpg"
                                                                    alt="Solo Travel: Some Tips and Destinations for the Adventurous Explorer"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="position-cover bg-gradient-to-t from-black to-transparent opacity-90">
                                                        </div>
                                                        <div class="post-header panel vstack justify-end items-start gap-1 p-2 sm:p-4 position-cover text-white"
                                                            data-swiper-parallax-y="-24">
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>2mo</span>
                                                            </div>
                                                            <h3
                                                                class="post-title h5 lg:h4 xl:h3 m-0 max-w-600px text-white text-truncate-2">
                                                                <a class="text-none text-white"
                                                                    href="blog-details.html">Solo Travel: Some Tips and
                                                                    Destinations for the Adventurous Explorer</a>
                                                            </h3>
                                                            <div>
                                                                <div
                                                                    class="post-meta panel hstack justify-between fs-7 text-white text-opacity-60 mt-1">
                                                                    <div class="meta">
                                                                        <div class="hstack gap-2">
                                                                            <div>
                                                                                <div class="post-author hstack gap-1">
                                                                                    <a href="page-author.html"
                                                                                        data-uc-tooltip="Peter Sawyer"><img
                                                                                            src="../assets/images/avatars/02.png"
                                                                                            alt="Peter Sawyer"
                                                                                            class="w-24px h-24px rounded-circle"></a>
                                                                                    <a href="page-author.html"
                                                                                        class="text-black dark:text-white text-none fw-bold">Peter
                                                                                        Sawyer</a>
                                                                                </div>
                                                                            </div>
                                                                            <div>
                                                                                <a href="#post_comment"
                                                                                    class="post-comments text-none hstack gap-narrow">
                                                                                    <i class="icon-narrow unicon-chat"></i>
                                                                                    <span>5</span>
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
                                                    </article>
                                                </div>
                                                <div class="swiper-slide">
                                                    <article
                                                        class="post type-post panel uc-transition-toggle vstack gap-2 lg:gap-3 h-100 overflow-hidden uc-dark">
                                                        <div class="post-media panel overflow-hidden h-100">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 h-100 d-none md:d-block">
                                                                <canvas class="h-100 w-100"></canvas>
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-15.jpg"
                                                                    alt="Gaming in the Age of AI: Strategies for Startups"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-16x9 d-block md:d-none">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-15.jpg"
                                                                    alt="Gaming in the Age of AI: Strategies for Startups"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="position-cover bg-gradient-to-t from-black to-transparent opacity-90">
                                                        </div>
                                                        <div class="post-header panel vstack justify-end items-start gap-1 p-2 sm:p-4 position-cover text-white"
                                                            data-swiper-parallax-y="-24">
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>9mo</span>
                                                            </div>
                                                            <h3
                                                                class="post-title h5 lg:h4 xl:h3 m-0 max-w-600px text-white text-truncate-2">
                                                                <a class="text-none text-white"
                                                                    href="blog-details.html">Gaming in the Age of AI:
                                                                    Strategies for Startups</a>
                                                            </h3>
                                                            <div>
                                                                <div
                                                                    class="post-meta panel hstack justify-between fs-7 text-white text-opacity-60 mt-1">
                                                                    <div class="meta">
                                                                        <div class="hstack gap-2">
                                                                            <div>
                                                                                <div class="post-author hstack gap-1">
                                                                                    <a href="page-author.html"
                                                                                        data-uc-tooltip="Peter Sawyer"><img
                                                                                            src="../assets/images/avatars/02.png"
                                                                                            alt="Peter Sawyer"
                                                                                            class="w-24px h-24px rounded-circle"></a>
                                                                                    <a href="page-author.html"
                                                                                        class="text-black dark:text-white text-none fw-bold">Peter
                                                                                        Sawyer</a>
                                                                                </div>
                                                                            </div>
                                                                            <div>
                                                                                <a href="#post_comment"
                                                                                    class="post-comments text-none hstack gap-narrow">
                                                                                    <i class="icon-narrow unicon-chat"></i>
                                                                                    <span>19</span>
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
                                                    </article>
                                                </div>
                                                <div class="swiper-slide">
                                                    <article
                                                        class="post type-post panel uc-transition-toggle vstack gap-2 lg:gap-3 h-100 overflow-hidden uc-dark">
                                                        <div class="post-media panel overflow-hidden h-100">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 h-100 d-none md:d-block">
                                                                <canvas class="h-100 w-100"></canvas>
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-18.jpg"
                                                                    alt="Virtual Reality and Mental Health: Exploring the Therapeutic"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-16x9 d-block md:d-none">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-18.jpg"
                                                                    alt="Virtual Reality and Mental Health: Exploring the Therapeutic"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="position-cover bg-gradient-to-t from-black to-transparent opacity-90">
                                                        </div>
                                                        <div class="post-header panel vstack justify-end items-start gap-1 p-2 sm:p-4 position-cover text-white"
                                                            data-swiper-parallax-y="-24">
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>2mo</span>
                                                            </div>
                                                            <h3
                                                                class="post-title h5 lg:h4 xl:h3 m-0 max-w-600px text-white text-truncate-2">
                                                                <a class="text-none text-white"
                                                                    href="blog-details.html">Virtual Reality and Mental
                                                                    Health: Exploring the Therapeutic</a>
                                                            </h3>
                                                            <div>
                                                                <div
                                                                    class="post-meta panel hstack justify-between fs-7 text-white text-opacity-60 mt-1">
                                                                    <div class="meta">
                                                                        <div class="hstack gap-2">
                                                                            <div>
                                                                                <div class="post-author hstack gap-1">
                                                                                    <a href="page-author.html"
                                                                                        data-uc-tooltip="Nisi Nyung"><img
                                                                                            src="../assets/images/avatars/08.png"
                                                                                            alt="Nisi Nyung"
                                                                                            class="w-24px h-24px rounded-circle"></a>
                                                                                    <a href="page-author.html"
                                                                                        class="text-black dark:text-white text-none fw-bold">Nisi
                                                                                        Nyung</a>
                                                                                </div>
                                                                            </div>
                                                                            <div>
                                                                                <a href="#post_comment"
                                                                                    class="post-comments text-none hstack gap-narrow">
                                                                                    <i class="icon-narrow unicon-chat"></i>
                                                                                    <span>290</span>
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
                                                    </article>
                                                </div>
                                                <div class="swiper-slide">
                                                    <article
                                                        class="post type-post panel uc-transition-toggle vstack gap-2 lg:gap-3 h-100 overflow-hidden uc-dark">
                                                        <div class="post-media panel overflow-hidden h-100">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 h-100 d-none md:d-block">
                                                                <canvas class="h-100 w-100"></canvas>
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-20.jpg"
                                                                    alt="Smart Homes, Smarter Living: Exploring IoT and AI"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-16x9 d-block md:d-none">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-20.jpg"
                                                                    alt="Smart Homes, Smarter Living: Exploring IoT and AI"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="position-cover bg-gradient-to-t from-black to-transparent opacity-90">
                                                        </div>
                                                        <div class="post-header panel vstack justify-end items-start gap-1 p-2 sm:p-4 position-cover text-white"
                                                            data-swiper-parallax-y="-24">
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>23d</span>
                                                            </div>
                                                            <h3
                                                                class="post-title h5 lg:h4 xl:h3 m-0 max-w-600px text-white text-truncate-2">
                                                                <a class="text-none text-white"
                                                                    href="blog-details.html">Smart Homes, Smarter Living:
                                                                    Exploring IoT and AI</a>
                                                            </h3>
                                                            <div>
                                                                <div
                                                                    class="post-meta panel hstack justify-between fs-7 text-white text-opacity-60 mt-1">
                                                                    <div class="meta">
                                                                        <div class="hstack gap-2">
                                                                            <div>
                                                                                <div class="post-author hstack gap-1">
                                                                                    <a href="page-author.html"
                                                                                        data-uc-tooltip="David Peterson"><img
                                                                                            src="../assets/images/avatars/01.png"
                                                                                            alt="David Peterson"
                                                                                            class="w-24px h-24px rounded-circle"></a>
                                                                                    <a href="page-author.html"
                                                                                        class="text-black dark:text-white text-none fw-bold">David
                                                                                        Peterson</a>
                                                                                </div>
                                                                            </div>
                                                                            <div>
                                                                                <a href="#post_comment"
                                                                                    class="post-comments text-none hstack gap-narrow">
                                                                                    <i class="icon-narrow unicon-chat"></i>
                                                                                    <span>15</span>
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
                                                    </article>
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="swiper-nav nav-prev position-absolute top-50 start-0 translate-middle-y btn btn-alt-primary text-black rounded-circle p-0 mx-2 border-0 shadow-xs w-32px h-32px z-1 uc-hidden-hover">
                                            <i class="icon-1 unicon-chevron-left"></i>
                                        </div>
                                        <div
                                            class="swiper-nav nav-next position-absolute top-50 end-0 translate-middle-y btn btn-alt-primary text-black rounded-circle p-0 mx-2 border-0 shadow-xs w-32px h-32px z-1 uc-hidden-hover">
                                            <i class="icon-1 unicon-chevron-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="lg:col-3">
                                <div class="panel cstack gap-2 h-100">
                                    <div>
                                        <div class="widget ad-widget vstack gap-2">
                                            <div class="widget-title text-center">
                                                <h5 class="fs-7 ft-tertiary text-uppercase m-0">Sponsore</h5>
                                            </div>
                                            <div class="widget-content">
                                                <a class="cstack max-w-300px mx-auto text-none"
                                                    href="https://themeforest.net/user/reacthemes/portfolio"
                                                    target="_blank" rel="nofollow">
                                                    <img class="d-none sm:d-block"
                                                        src="../assets/images/common/ad-desktop.jpg" alt="Ad slot">
                                                    <img class="d-block sm:d-none"
                                                        src="../assets/images/common/ad-mobile.jpg" alt="Ad slot">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Section end -->

    <!-- Section start -->
    <div class="section panel overflow-hidden">
        <div class="section-outer panel">
            <div class="container max-w-xl">
                <div class="section-inner">
                    <div class="row child-cols-12 lg:child-cols g-4 lg:g-6 col-match" data-uc-grid>
                        <div class="lg:col-8">
                            <div class="block-layout grid-layout vstack gap-2 lg:gap-3 panel overflow-hidden">
                                <div class="block-header panel pt-1 border-top">
                                    <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">
                                        <a class="hstack d-inline-flex gap-0 text-none hover:text-primary duration-150"
                                            href="blog-category.html">
                                            <span>Poltics</span>
                                            <i class="icon-1 fw-bold unicon-chevron-right"></i>
                                        </a>
                                    </h2>
                                </div>
                                <div class="block-content">
                                    <div class="panel row child-cols-12 md:child-cols g-2 lg:g-4 col-match sep-y"
                                        data-uc-grid>
                                        <div class="col-12 md:col-6 order-0 md:order-1">
                                            <div>
                                                <article
                                                    class="post type-post panel uc-transition-toggle vstack gap-2 lg:gap-3 h-100 overflow-hidden uc-dark">
                                                    <div class="post-media panel overflow-hidden h-100">
                                                        <div
                                                            class="featured-image bg-gray-25 dark:bg-gray-800 h-100 d-none md:d-block">
                                                            <canvas class="h-100 w-100"></canvas>
                                                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                src="../assets/images/common/img-fallback.png"
                                                                data-src="../assets/images/demo-seven/posts/img-04.jpg"
                                                                alt="The Importance of Sleep: Tips for Better Rest and Recovery"
                                                                data-uc-img="loading: lazy">
                                                        </div>
                                                        <div
                                                            class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-16x9 d-block md:d-none">
                                                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                src="../assets/images/common/img-fallback.png"
                                                                data-src="../assets/images/demo-seven/posts/img-04.jpg"
                                                                alt="The Importance of Sleep: Tips for Better Rest and Recovery"
                                                                data-uc-img="loading: lazy">
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="position-cover bg-gradient-to-t from-black to-transparent opacity-90">
                                                    </div>
                                                    <div
                                                        class="post-header panel vstack justify-end items-start gap-1 p-2 sm:p-4 position-cover text-white">
                                                        <div
                                                            class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                            <span>2h</span>
                                                        </div>
                                                        <h3
                                                            class="post-title h5 lg:h4 m-0 max-w-600px text-white text-truncate-2">
                                                            <a class="text-none text-white" href="blog-details.html">The
                                                                Importance of Sleep: Tips for Better Rest and Recovery</a>
                                                        </h3>
                                                        <div>
                                                            <div
                                                                class="post-meta panel hstack justify-between fs-7 text-white text-opacity-60 mt-1">
                                                                <div class="meta">
                                                                    <div class="hstack gap-2">
                                                                        <div>
                                                                            <div class="post-author hstack gap-1">
                                                                                <a href="page-author.html"
                                                                                    data-uc-tooltip="Sarah Eddrissi"><img
                                                                                        src="../assets/images/avatars/03.png"
                                                                                        alt="Sarah Eddrissi"
                                                                                        class="w-24px h-24px rounded-circle"></a>
                                                                                <a href="page-author.html"
                                                                                    class="text-black dark:text-white text-none fw-bold">Sarah
                                                                                    Eddrissi</a>
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <a href="#post_comment"
                                                                                class="post-comments text-none hstack gap-narrow">
                                                                                <i class="icon-narrow unicon-chat"></i>
                                                                                <span>0</span>
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
                                                </article>
                                            </div>
                                        </div>
                                        <div class="order-1 md:order-0">
                                            <div class="row child-cols-12 g-2 lg:g-4 sep-x" data-uc-grid>
                                                <div>
                                                    <article class="post type-post panel uc-transition-toggle">
                                                        <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                            <div>
                                                                <div
                                                                    class="post-header panel vstack justify-between gap-1">
                                                                    <h3 class="post-title h6 m-0 text-truncate-2">
                                                                        <a class="text-none hover:text-primary duration-150"
                                                                            href="blog-details.html">The Future of
                                                                            Sustainable Living: Driving Eco-Friendly
                                                                            Lifestyles</a>
                                                                    </h3>
                                                                    <div
                                                                        class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                        <span>12h</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div
                                                                    class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                                    <div
                                                                        class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                            src="../assets/images/common/img-fallback.png"
                                                                            data-src="../assets/images/demo-seven/posts/img-05.jpg"
                                                                            alt="The Future of Sustainable Living: Driving Eco-Friendly Lifestyles"
                                                                            data-uc-img="loading: lazy">
                                                                    </div>
                                                                    <a href="blog-details.html"
                                                                        class="position-cover"></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                                <div>
                                                    <article class="post type-post panel uc-transition-toggle">
                                                        <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                            <div>
                                                                <div
                                                                    class="post-header panel vstack justify-between gap-1">
                                                                    <h3 class="post-title h6 m-0 text-truncate-2">
                                                                        <a class="text-none hover:text-primary duration-150"
                                                                            href="blog-details.html">Eco-Tourism: Traveling
                                                                            Responsibly and Sustainably</a>
                                                                    </h3>
                                                                    <div
                                                                        class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                        <span>29d</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div
                                                                    class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                                    <div
                                                                        class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                            src="../assets/images/common/img-fallback.png"
                                                                            data-src="../assets/images/demo-seven/posts/img-10.jpg"
                                                                            alt="Eco-Tourism: Traveling Responsibly and Sustainably"
                                                                            data-uc-img="loading: lazy">
                                                                    </div>
                                                                    <a href="blog-details.html"
                                                                        class="position-cover"></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                                <div>
                                                    <article class="post type-post panel uc-transition-toggle">
                                                        <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                            <div>
                                                                <div
                                                                    class="post-header panel vstack justify-between gap-1">
                                                                    <h3 class="post-title h6 m-0 text-truncate-2">
                                                                        <a class="text-none hover:text-primary duration-150"
                                                                            href="blog-details.html">Tech Tools for your
                                                                            Time Management: Enhancing Productivity</a>
                                                                    </h3>
                                                                    <div
                                                                        class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                        <span>3mo</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div
                                                                    class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                                    <div
                                                                        class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                            src="../assets/images/common/img-fallback.png"
                                                                            data-src="../assets/images/demo-seven/posts/img-13.jpg"
                                                                            alt="Tech Tools for your Time Management: Enhancing Productivity"
                                                                            data-uc-img="loading: lazy">
                                                                    </div>
                                                                    <a href="blog-details.html"
                                                                        class="position-cover"></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                                <div>
                                                    <article class="post type-post panel uc-transition-toggle">
                                                        <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                            <div>
                                                                <div
                                                                    class="post-header panel vstack justify-between gap-1">
                                                                    <h3 class="post-title h6 m-0 text-truncate-2">
                                                                        <a class="text-none hover:text-primary duration-150"
                                                                            href="blog-details.html">Potential of Immersive
                                                                            Technologies help your Business Grow</a>
                                                                    </h3>
                                                                    <div
                                                                        class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                        <span>1yr</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div
                                                                    class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                                    <div
                                                                        class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                            src="../assets/images/common/img-fallback.png"
                                                                            data-src="../assets/images/demo-seven/posts/img-17.jpg"
                                                                            alt="Potential of Immersive Technologies help your Business Grow"
                                                                            data-uc-img="loading: lazy">
                                                                    </div>
                                                                    <a href="blog-details.html"
                                                                        class="position-cover"></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-4">
                            <div class="block-layout grid-layout vstack gap-2 lg:gap-3 panel overflow-hidden">
                                <div class="block-header panel pt-1 border-top">
                                    <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">
                                        <a class="hstack d-inline-flex gap-0 text-none hover:text-primary duration-150"
                                            href="blog-category.html">
                                            <span>Media</span>
                                            <i class="icon-1 fw-bold unicon-chevron-right"></i>
                                        </a>
                                    </h2>
                                </div>
                                <div class="block-content">
                                    <div class="row child-cols-12 g-2 lg:g-4 sep-x" data-uc-grid>
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle">
                                                <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">Solo Travel: Some Tips and
                                                                    Destinations for the Adventurous Explorer</a>
                                                            </h3>
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>2mo</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div
                                                            class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-11.jpg"
                                                                    alt="Solo Travel: Some Tips and Destinations for the Adventurous Explorer"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle">
                                                <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">Gaming in the Age of AI:
                                                                    Strategies for Startups</a>
                                                            </h3>
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>9mo</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div
                                                            class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-15.jpg"
                                                                    alt="Gaming in the Age of AI: Strategies for Startups"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle">
                                                <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">Virtual Reality and Mental
                                                                    Health: Exploring the Therapeutic</a>
                                                            </h3>
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>2mo</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div
                                                            class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-18.jpg"
                                                                    alt="Virtual Reality and Mental Health: Exploring the Therapeutic"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle">
                                                <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">Smart Homes, Smarter Living:
                                                                    Exploring IoT and AI</a>
                                                            </h3>
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>23d</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div
                                                            class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-20.jpg"
                                                                    alt="Smart Homes, Smarter Living: Exploring IoT and AI"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Section end -->

    <!-- Section start -->
    <div class="section panel overflow-hidden swiper-parent">
        <div class="section-outer panel py-4 lg:py-6 dark:text-white">
            <div class="container max-w-xl">
                <div class="section-inner panel vstack gap-2">
                    <div class="block-layout carousel-layout vstack gap-2 lg:gap-3 panel">
                        <div class="block-header panel pt-1 border-top">
                            <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">Hot now
                            </h2>
                        </div>
                        <div class="block-content panel">
                            <div class="swiper"
                                data-uc-swiper="items: 2; gap: 16; dots: .dot-nav; next: .nav-next; prev: .nav-prev; disable-class: d-none;"
                                data-uc-swiper-s="items: 3; gap: 24;" data-uc-swiper-l="items: 5; gap: 24;">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle vstack gap-2">
                                                <div class="post-media panel overflow-hidden">
                                                    <div
                                                        class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                            src="../assets/images/common/img-fallback.png"
                                                            data-src="../assets/images/demo-seven/posts/img-09.jpg"
                                                            alt="Hidden Gems: Underrated Travel Destinations Around the World"
                                                            data-uc-img="loading: lazy">
                                                    </div>
                                                    <a href="blog-details.html" class="position-cover"></a>
                                                </div>
                                                <div class="post-header panel vstack gap-1">
                                                    <h3 class="post-title h6 m-0 text-truncate-2">
                                                        <a class="text-none hover:text-primary duration-150"
                                                            href="blog-details.html">Hidden Gems: Underrated Travel
                                                            Destinations Around the World</a>
                                                    </h3>
                                                    <div
                                                        class="post-meta panel hstack justify-start gap-1 fs-7 ft-tertiary fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1 d-none md:d-block">
                                                        <div>
                                                            <div class="post-date hstack gap-narrow">
                                                                <span>23d</span>
                                                            </div>
                                                        </div>
                                                        <div>·</div>
                                                        <div>
                                                            <a href="#post_comment"
                                                                class="post-comments text-none hstack gap-narrow">
                                                                <i class="icon-narrow unicon-chat"></i>
                                                                <span>15</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle vstack gap-2">
                                                <div class="post-media panel overflow-hidden">
                                                    <div
                                                        class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                            src="../assets/images/common/img-fallback.png"
                                                            data-src="../assets/images/demo-seven/posts/img-10.jpg"
                                                            alt="Eco-Tourism: Traveling Responsibly and Sustainably"
                                                            data-uc-img="loading: lazy">
                                                    </div>
                                                    <a href="blog-details.html" class="position-cover"></a>
                                                </div>
                                                <div class="post-header panel vstack gap-1">
                                                    <h3 class="post-title h6 m-0 text-truncate-2">
                                                        <a class="text-none hover:text-primary duration-150"
                                                            href="blog-details.html">Eco-Tourism: Traveling Responsibly and
                                                            Sustainably</a>
                                                    </h3>
                                                    <div
                                                        class="post-meta panel hstack justify-start gap-1 fs-7 ft-tertiary fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1 d-none md:d-block">
                                                        <div>
                                                            <div class="post-date hstack gap-narrow">
                                                                <span>29d</span>
                                                            </div>
                                                        </div>
                                                        <div>·</div>
                                                        <div>
                                                            <a href="#post_comment"
                                                                class="post-comments text-none hstack gap-narrow">
                                                                <i class="icon-narrow unicon-chat"></i>
                                                                <span>20</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle vstack gap-2">
                                                <div class="post-media panel overflow-hidden">
                                                    <div
                                                        class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                            src="../assets/images/common/img-fallback.png"
                                                            data-src="../assets/images/demo-seven/posts/img-11.jpg"
                                                            alt="Solo Travel: Some Tips and Destinations for the Adventurous Explorer"
                                                            data-uc-img="loading: lazy">
                                                    </div>
                                                    <a href="blog-details.html" class="position-cover"></a>
                                                </div>
                                                <div class="post-header panel vstack gap-1">
                                                    <h3 class="post-title h6 m-0 text-truncate-2">
                                                        <a class="text-none hover:text-primary duration-150"
                                                            href="blog-details.html">Solo Travel: Some Tips and
                                                            Destinations for the Adventurous Explorer</a>
                                                    </h3>
                                                    <div
                                                        class="post-meta panel hstack justify-start gap-1 fs-7 ft-tertiary fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1 d-none md:d-block">
                                                        <div>
                                                            <div class="post-date hstack gap-narrow">
                                                                <span>2mo</span>
                                                            </div>
                                                        </div>
                                                        <div>·</div>
                                                        <div>
                                                            <a href="#post_comment"
                                                                class="post-comments text-none hstack gap-narrow">
                                                                <i class="icon-narrow unicon-chat"></i>
                                                                <span>5</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle vstack gap-2">
                                                <div class="post-media panel overflow-hidden">
                                                    <div
                                                        class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                            src="../assets/images/common/img-fallback.png"
                                                            data-src="../assets/images/demo-seven/posts/img-12.jpg"
                                                            alt="AI-Powered Financial Planning: How Algorithms Revolutionizing"
                                                            data-uc-img="loading: lazy">
                                                    </div>
                                                    <a href="blog-details.html" class="position-cover"></a>
                                                </div>
                                                <div class="post-header panel vstack gap-1">
                                                    <h3 class="post-title h6 m-0 text-truncate-2">
                                                        <a class="text-none hover:text-primary duration-150"
                                                            href="blog-details.html">AI-Powered Financial Planning: How
                                                            Algorithms Revolutionizing</a>
                                                    </h3>
                                                    <div
                                                        class="post-meta panel hstack justify-start gap-1 fs-7 ft-tertiary fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1 d-none md:d-block">
                                                        <div>
                                                            <div class="post-date hstack gap-narrow">
                                                                <span>2mo</span>
                                                            </div>
                                                        </div>
                                                        <div>·</div>
                                                        <div>
                                                            <a href="#post_comment"
                                                                class="post-comments text-none hstack gap-narrow">
                                                                <i class="icon-narrow unicon-chat"></i>
                                                                <span>2</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle vstack gap-2">
                                                <div class="post-media panel overflow-hidden">
                                                    <div
                                                        class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                            src="../assets/images/common/img-fallback.png"
                                                            data-src="../assets/images/demo-seven/posts/img-13.jpg"
                                                            alt="Tech Tools for your Time Management: Enhancing Productivity"
                                                            data-uc-img="loading: lazy">
                                                    </div>
                                                    <a href="blog-details.html" class="position-cover"></a>
                                                </div>
                                                <div class="post-header panel vstack gap-1">
                                                    <h3 class="post-title h6 m-0 text-truncate-2">
                                                        <a class="text-none hover:text-primary duration-150"
                                                            href="blog-details.html">Tech Tools for your Time Management:
                                                            Enhancing Productivity</a>
                                                    </h3>
                                                    <div
                                                        class="post-meta panel hstack justify-start gap-1 fs-7 ft-tertiary fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1 d-none md:d-block">
                                                        <div>
                                                            <div class="post-date hstack gap-narrow">
                                                                <span>3mo</span>
                                                            </div>
                                                        </div>
                                                        <div>·</div>
                                                        <div>
                                                            <a href="#post_comment"
                                                                class="post-comments text-none hstack gap-narrow">
                                                                <i class="icon-narrow unicon-chat"></i>
                                                                <span>19</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle vstack gap-2">
                                                <div class="post-media panel overflow-hidden">
                                                    <div
                                                        class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                            src="../assets/images/common/img-fallback.png"
                                                            data-src="../assets/images/demo-seven/posts/img-14.jpg"
                                                            alt="A Guide to The Rise of Gourmet Street Food: Trends and Top Picks"
                                                            data-uc-img="loading: lazy">
                                                    </div>
                                                    <a href="blog-details.html" class="position-cover"></a>
                                                </div>
                                                <div class="post-header panel vstack gap-1">
                                                    <h3 class="post-title h6 m-0 text-truncate-2">
                                                        <a class="text-none hover:text-primary duration-150"
                                                            href="blog-details.html">A Guide to The Rise of Gourmet Street
                                                            Food: Trends and Top Picks</a>
                                                    </h3>
                                                    <div
                                                        class="post-meta panel hstack justify-start gap-1 fs-7 ft-tertiary fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1 d-none md:d-block">
                                                        <div>
                                                            <div class="post-date hstack gap-narrow">
                                                                <span>6mo</span>
                                                            </div>
                                                        </div>
                                                        <div>·</div>
                                                        <div>
                                                            <a href="#post_comment"
                                                                class="post-comments text-none hstack gap-narrow">
                                                                <i class="icon-narrow unicon-chat"></i>
                                                                <span>2</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle vstack gap-2">
                                                <div class="post-media panel overflow-hidden">
                                                    <div
                                                        class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                            src="../assets/images/common/img-fallback.png"
                                                            data-src="../assets/images/demo-seven/posts/img-15.jpg"
                                                            alt="Gaming in the Age of AI: Strategies for Startups"
                                                            data-uc-img="loading: lazy">
                                                    </div>
                                                    <a href="blog-details.html" class="position-cover"></a>
                                                </div>
                                                <div class="post-header panel vstack gap-1">
                                                    <h3 class="post-title h6 m-0 text-truncate-2">
                                                        <a class="text-none hover:text-primary duration-150"
                                                            href="blog-details.html">Gaming in the Age of AI: Strategies
                                                            for Startups</a>
                                                    </h3>
                                                    <div
                                                        class="post-meta panel hstack justify-start gap-1 fs-7 ft-tertiary fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1 d-none md:d-block">
                                                        <div>
                                                            <div class="post-date hstack gap-narrow">
                                                                <span>9mo</span>
                                                            </div>
                                                        </div>
                                                        <div>·</div>
                                                        <div>
                                                            <a href="#post_comment"
                                                                class="post-comments text-none hstack gap-narrow">
                                                                <i class="icon-narrow unicon-chat"></i>
                                                                <span>19</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle vstack gap-2">
                                                <div class="post-media panel overflow-hidden">
                                                    <div
                                                        class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                            src="../assets/images/common/img-fallback.png"
                                                            data-src="../assets/images/demo-seven/posts/img-16.jpg"
                                                            alt="Top Independent Contractors to Invest in Best of Startups"
                                                            data-uc-img="loading: lazy">
                                                    </div>
                                                    <a href="blog-details.html" class="position-cover"></a>
                                                </div>
                                                <div class="post-header panel vstack gap-1">
                                                    <h3 class="post-title h6 m-0 text-truncate-2">
                                                        <a class="text-none hover:text-primary duration-150"
                                                            href="blog-details.html">Top Independent Contractors to Invest
                                                            in Best of Startups</a>
                                                    </h3>
                                                    <div
                                                        class="post-meta panel hstack justify-start gap-1 fs-7 ft-tertiary fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1 d-none md:d-block">
                                                        <div>
                                                            <div class="post-date hstack gap-narrow">
                                                                <span>1yr</span>
                                                            </div>
                                                        </div>
                                                        <div>·</div>
                                                        <div>
                                                            <a href="#post_comment"
                                                                class="post-comments text-none hstack gap-narrow">
                                                                <i class="icon-narrow unicon-chat"></i>
                                                                <span>12</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="swiper-nav nav-prev position-absolute top-50 start-0 translate-middle btn btn-alt-primary text-black rounded-circle p-0 border shadow-xs w-32px lg:w-40px h-32px lg:h-40px z-1">
                                <i class="icon-1 unicon-chevron-left"></i>
                            </div>
                            <div
                                class="swiper-nav nav-next position-absolute top-50 start-100 translate-middle btn btn-alt-primary text-black rounded-circle p-0 border shadow-xs w-32px lg:w-40px h-32px lg:h-40px z-1">
                                <i class="icon-1 unicon-chevron-right"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Section end -->

    <!-- Section start -->
    <div class="section panel overflow-hidden">
        <div class="section-outer panel">
            <div class="container max-w-xl">
                <div class="section-inner">
                    <div class="row child-cols-12 lg:child-cols g-4 lg:g-6 col-match" data-uc-grid>
                        <div class="lg:col-8 order-0 lg:order-2">
                            <div class="block-layout grid-layout vstack gap-2 lg:gap-3 panel overflow-hidden">
                                <div class="block-header panel pt-1 border-top">
                                    <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">
                                        <a class="hstack d-inline-flex gap-0 text-none hover:text-primary duration-150"
                                            href="blog-category.html">
                                            <span>Opinions</span>
                                            <i class="icon-1 fw-bold unicon-chevron-right"></i>
                                        </a>
                                    </h2>
                                </div>
                                <div class="block-content">
                                    <div class="panel row child-cols-12 md:child-cols g-2 lg:g-4 col-match sep-y"
                                        data-uc-grid>
                                        <div class="col-12 md:col-6 order-0 md:order-1">
                                            <div>
                                                <article
                                                    class="post type-post panel uc-transition-toggle vstack gap-2 lg:gap-3 h-100 overflow-hidden uc-dark">
                                                    <div class="post-media panel overflow-hidden h-100">
                                                        <div
                                                            class="featured-image bg-gray-25 dark:bg-gray-800 h-100 d-none md:d-block">
                                                            <canvas class="h-100 w-100"></canvas>
                                                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                src="../assets/images/common/img-fallback.png"
                                                                data-src="../assets/images/demo-seven/posts/img-01.jpg"
                                                                alt="The Rise of AI-Powered Personal Assistants: How They Manage"
                                                                data-uc-img="loading: lazy">
                                                        </div>
                                                        <div
                                                            class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-16x9 d-block md:d-none">
                                                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                src="../assets/images/common/img-fallback.png"
                                                                data-src="../assets/images/demo-seven/posts/img-01.jpg"
                                                                alt="The Rise of AI-Powered Personal Assistants: How They Manage"
                                                                data-uc-img="loading: lazy">
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="position-cover bg-gradient-to-t from-black to-transparent opacity-90">
                                                    </div>
                                                    <div
                                                        class="post-header panel vstack justify-end items-start gap-1 p-2 sm:p-4 position-cover text-white">
                                                        <div
                                                            class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                            <span>1min</span>
                                                        </div>
                                                        <h3
                                                            class="post-title h5 lg:h4 m-0 max-w-600px text-white text-truncate-2">
                                                            <a class="text-none text-white" href="blog-details.html">The
                                                                Rise of AI-Powered Personal Assistants: How They Manage</a>
                                                        </h3>
                                                        <div>
                                                            <div
                                                                class="post-meta panel hstack justify-between fs-7 text-white text-opacity-60 mt-1">
                                                                <div class="meta">
                                                                    <div class="hstack gap-2">
                                                                        <div>
                                                                            <div class="post-author hstack gap-1">
                                                                                <a href="page-author.html"
                                                                                    data-uc-tooltip="David Peterson"><img
                                                                                        src="../assets/images/avatars/01.png"
                                                                                        alt="David Peterson"
                                                                                        class="w-24px h-24px rounded-circle"></a>
                                                                                <a href="page-author.html"
                                                                                    class="text-black dark:text-white text-none fw-bold">David
                                                                                    Peterson</a>
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <a href="#post_comment"
                                                                                class="post-comments text-none hstack gap-narrow">
                                                                                <i class="icon-narrow unicon-chat"></i>
                                                                                <span>2</span>
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
                                                </article>
                                            </div>
                                        </div>
                                        <div class="order-1 md:order-0">
                                            <div class="row child-cols-12 g-2 lg:g-4 sep-x" data-uc-grid>
                                                <div>
                                                    <article class="post type-post panel uc-transition-toggle">
                                                        <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                            <div>
                                                                <div
                                                                    class="post-header panel vstack justify-between gap-1">
                                                                    <h3 class="post-title h6 m-0 text-truncate-2">
                                                                        <a class="text-none hover:text-primary duration-150"
                                                                            href="blog-details.html">Business Agility the
                                                                            Digital Age: Leveraging AI and Automation</a>
                                                                    </h3>
                                                                    <div
                                                                        class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                        <span>7d</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div
                                                                    class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                                    <div
                                                                        class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                            src="../assets/images/common/img-fallback.png"
                                                                            data-src="../assets/images/demo-seven/posts/img-06.jpg"
                                                                            alt="Business Agility the Digital Age: Leveraging AI and Automation"
                                                                            data-uc-img="loading: lazy">
                                                                    </div>
                                                                    <a href="blog-details.html"
                                                                        class="position-cover"></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                                <div>
                                                    <article class="post type-post panel uc-transition-toggle">
                                                        <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                            <div>
                                                                <div
                                                                    class="post-header panel vstack justify-between gap-1">
                                                                    <h3 class="post-title h6 m-0 text-truncate-2">
                                                                        <a class="text-none hover:text-primary duration-150"
                                                                            href="blog-details.html">A Guide to The Rise of
                                                                            Gourmet Street Food: Trends and Top Picks</a>
                                                                    </h3>
                                                                    <div
                                                                        class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                        <span>6mo</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div
                                                                    class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                                    <div
                                                                        class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                            src="../assets/images/common/img-fallback.png"
                                                                            data-src="../assets/images/demo-seven/posts/img-14.jpg"
                                                                            alt="A Guide to The Rise of Gourmet Street Food: Trends and Top Picks"
                                                                            data-uc-img="loading: lazy">
                                                                    </div>
                                                                    <a href="blog-details.html"
                                                                        class="position-cover"></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                                <div>
                                                    <article class="post type-post panel uc-transition-toggle">
                                                        <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                            <div>
                                                                <div
                                                                    class="post-header panel vstack justify-between gap-1">
                                                                    <h3 class="post-title h6 m-0 text-truncate-2">
                                                                        <a class="text-none hover:text-primary duration-150"
                                                                            href="blog-details.html">Top Independent
                                                                            Contractors to Invest in Best of Startups</a>
                                                                    </h3>
                                                                    <div
                                                                        class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                        <span>1yr</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div
                                                                    class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                                    <div
                                                                        class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                            src="../assets/images/common/img-fallback.png"
                                                                            data-src="../assets/images/demo-seven/posts/img-16.jpg"
                                                                            alt="Top Independent Contractors to Invest in Best of Startups"
                                                                            data-uc-img="loading: lazy">
                                                                    </div>
                                                                    <a href="blog-details.html"
                                                                        class="position-cover"></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                                <div>
                                                    <article class="post type-post panel uc-transition-toggle">
                                                        <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                            <div>
                                                                <div
                                                                    class="post-header panel vstack justify-between gap-1">
                                                                    <h3 class="post-title h6 m-0 text-truncate-2">
                                                                        <a class="text-none hover:text-primary duration-150"
                                                                            href="blog-details.html">The Future of
                                                                            Sustainable Living: Driving Eco-Friendly
                                                                            Lifestyles</a>
                                                                    </h3>
                                                                    <div
                                                                        class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                        <span>2mo</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-auto">
                                                                <div
                                                                    class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                                    <div
                                                                        class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                            src="../assets/images/common/img-fallback.png"
                                                                            data-src="../assets/images/demo-seven/posts/img-19.jpg"
                                                                            alt="The Future of Sustainable Living: Driving Eco-Friendly Lifestyles"
                                                                            data-uc-img="loading: lazy">
                                                                    </div>
                                                                    <a href="blog-details.html"
                                                                        class="position-cover"></a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-4 order-1">
                            <div class="block-layout grid-layout vstack gap-2 lg:gap-3 panel overflow-hidden">
                                <div class="block-header panel pt-1 border-top">
                                    <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">
                                        <a class="hstack d-inline-flex gap-0 text-none hover:text-primary duration-150"
                                            href="blog-category.html">
                                            <span>World</span>
                                            <i class="icon-1 fw-bold unicon-chevron-right"></i>
                                        </a>
                                    </h2>
                                </div>
                                <div class="block-content">
                                    <div class="row child-cols-12 g-2 lg:g-4 sep-x" data-uc-grid>
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle">
                                                <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">Tech Innovations Reshaping the
                                                                    Retail Landscape: AI Payments</a>
                                                            </h3>
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>55min</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div
                                                            class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-02.jpg"
                                                                    alt="Tech Innovations Reshaping the Retail Landscape: AI Payments"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle">
                                                <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">The Art of Baking: From
                                                                    Classic Bread to Artisan Pastries</a>
                                                            </h3>
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>9d</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div
                                                            class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-07.jpg"
                                                                    alt="The Art of Baking: From Classic Bread to Artisan Pastries"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle">
                                                <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">Hidden Gems: Underrated Travel
                                                                    Destinations Around the World</a>
                                                            </h3>
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>23d</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div
                                                            class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-09.jpg"
                                                                    alt="Hidden Gems: Underrated Travel Destinations Around the World"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle">
                                                <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">AI-Powered Financial Planning:
                                                                    How Algorithms Revolutionizing</a>
                                                            </h3>
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>2mo</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div
                                                            class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-12.jpg"
                                                                    alt="AI-Powered Financial Planning: How Algorithms Revolutionizing"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Section end -->

    <!-- Section start -->
    <div class="section panel overflow-hidden">
        <div class="section-outer panel py-4 lg:py-6 dark:text-white">
            <div class="container max-w-xl">
                <div class="section-inner">
                    <div class="row child-cols-12 lg:child-cols g-4 lg:g-6 col-match" data-uc-grid>
                        <div class="lg:col-4">
                            <div class="block-layout list-layout vstack gap-2 lg:gap-3 panel overflow-hidden">
                                <div class="block-header panel pt-1 border-top">
                                    <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">
                                        <a class="hstack d-inline-flex gap-0 text-none hover:text-primary duration-150"
                                            href="blog-category.html">
                                            <span>Tech</span>
                                            <i class="icon-1 fw-bold unicon-chevron-right"></i>
                                        </a>
                                    </h2>
                                </div>
                                <div class="block-content">
                                    <div class="row child-cols-12 g-2 lg:g-4 sep-x" data-uc-grid>
                                        <div>
                                            <article
                                                class="post type-post panel uc-transition-toggle vstack gap-2 lg:gap-3 overflow-hidden uc-dark">
                                                <div class="post-media panel overflow-hidden">
                                                    <div
                                                        class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-4x3">
                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                            src="../assets/images/common/img-fallback.png"
                                                            data-src="../assets/images/demo-seven/posts/img-01.jpg"
                                                            alt="The Rise of AI-Powered Personal Assistants: How They Manage"
                                                            data-uc-img="loading: lazy">
                                                    </div>
                                                </div>
                                                <div
                                                    class="position-cover bg-gradient-to-t from-black to-transparent opacity-90">
                                                </div>
                                                <div
                                                    class="post-header panel vstack justify-start items-start flex-column-reverse gap-1 p-2 position-cover text-white">
                                                    <div
                                                        class="post-meta panel hstack justify-between fs-7 text-white text-opacity-60 mt-1">
                                                        <div class="meta">
                                                            <div class="hstack gap-2">
                                                                <div>
                                                                    <div class="post-author hstack gap-1">
                                                                        <a href="page-author.html"
                                                                            data-uc-tooltip="David Peterson"><img
                                                                                src="../assets/images/avatars/01.png"
                                                                                alt="David Peterson"
                                                                                class="w-24px h-24px rounded-circle"></a>
                                                                        <a href="page-author.html"
                                                                            class="text-black dark:text-white text-none fw-bold">David
                                                                            Peterson</a>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <a href="#post_comment"
                                                                        class="post-comments text-none hstack gap-narrow">
                                                                        <i class="icon-narrow unicon-chat"></i>
                                                                        <span>2</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="actions">
                                                            <div class="hstack gap-1"></div>
                                                        </div>
                                                    </div>
                                                    <h3
                                                        class="post-title h6 lg:h5 m-0 m-0 max-w-600px text-white text-truncate-2">
                                                        <a class="text-none text-white" href="blog-details.html">The Rise
                                                            of AI-Powered Personal Assistants: How They Manage</a>
                                                    </h3>
                                                    <div
                                                        class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                        <span>1min</span>
                                                    </div>
                                                </div>
                                                <a href="blog-details.html" class="position-cover"></a>
                                            </article>
                                        </div>
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle">
                                                <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">Tech Innovations Reshaping the
                                                                    Retail Landscape: AI Payments</a>
                                                            </h3>
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>55min</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div
                                                            class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-02.jpg"
                                                                    alt="Tech Innovations Reshaping the Retail Landscape: AI Payments"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle">
                                                <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">Balancing Work and Wellness:
                                                                    Tech Solutions for Healthy</a>
                                                            </h3>
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>1h</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div
                                                            class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-03.jpg"
                                                                    alt="Balancing Work and Wellness: Tech Solutions for Healthy"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle">
                                                <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">The Importance of Sleep: Tips
                                                                    for Better Rest and Recovery</a>
                                                            </h3>
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>2h</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div
                                                            class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-04.jpg"
                                                                    alt="The Importance of Sleep: Tips for Better Rest and Recovery"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-4">
                            <div class="block-layout list-layout vstack gap-2 lg:gap-3 panel overflow-hidden">
                                <div class="block-header panel pt-1 border-top">
                                    <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">
                                        <a class="hstack d-inline-flex gap-0 text-none hover:text-primary duration-150"
                                            href="blog-category.html">
                                            <span>Business</span>
                                            <i class="icon-1 fw-bold unicon-chevron-right"></i>
                                        </a>
                                    </h2>
                                </div>
                                <div class="block-content">
                                    <div class="row child-cols-12 g-2 lg:g-4 sep-x" data-uc-grid>
                                        <div>
                                            <article
                                                class="post type-post panel uc-transition-toggle vstack gap-2 lg:gap-3 overflow-hidden uc-dark">
                                                <div class="post-media panel overflow-hidden">
                                                    <div
                                                        class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-4x3">
                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                            src="../assets/images/common/img-fallback.png"
                                                            data-src="../assets/images/demo-seven/posts/img-05.jpg"
                                                            alt="The Future of Sustainable Living: Driving Eco-Friendly Lifestyles"
                                                            data-uc-img="loading: lazy">
                                                    </div>
                                                </div>
                                                <div
                                                    class="position-cover bg-gradient-to-t from-black to-transparent opacity-90">
                                                </div>
                                                <div
                                                    class="post-header panel vstack justify-start items-start flex-column-reverse gap-1 p-2 position-cover text-white">
                                                    <div
                                                        class="post-meta panel hstack justify-between fs-7 text-white text-opacity-60 mt-1">
                                                        <div class="meta">
                                                            <div class="hstack gap-2">
                                                                <div>
                                                                    <div class="post-author hstack gap-1">
                                                                        <a href="page-author.html"
                                                                            data-uc-tooltip="Anna Luis"><img
                                                                                src="../assets/images/avatars/04.png"
                                                                                alt="Anna Luis"
                                                                                class="w-24px h-24px rounded-circle"></a>
                                                                        <a href="page-author.html"
                                                                            class="text-black dark:text-white text-none fw-bold">Anna
                                                                            Luis</a>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <a href="#post_comment"
                                                                        class="post-comments text-none hstack gap-narrow">
                                                                        <i class="icon-narrow unicon-chat"></i>
                                                                        <span>1</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="actions">
                                                            <div class="hstack gap-1"></div>
                                                        </div>
                                                    </div>
                                                    <h3
                                                        class="post-title h6 lg:h5 m-0 m-0 max-w-600px text-white text-truncate-2">
                                                        <a class="text-none text-white" href="blog-details.html">The
                                                            Future of Sustainable Living: Driving Eco-Friendly
                                                            Lifestyles</a>
                                                    </h3>
                                                    <div
                                                        class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                        <span>12h</span>
                                                    </div>
                                                </div>
                                                <a href="blog-details.html" class="position-cover"></a>
                                            </article>
                                        </div>
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle">
                                                <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">Business Agility the Digital
                                                                    Age: Leveraging AI and Automation</a>
                                                            </h3>
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>7d</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div
                                                            class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-06.jpg"
                                                                    alt="Business Agility the Digital Age: Leveraging AI and Automation"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle">
                                                <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">The Art of Baking: From
                                                                    Classic Bread to Artisan Pastries</a>
                                                            </h3>
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>9d</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div
                                                            class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-07.jpg"
                                                                    alt="The Art of Baking: From Classic Bread to Artisan Pastries"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle">
                                                <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">AI and Marketing: Unlocking
                                                                    Customer Insights</a>
                                                            </h3>
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>15d</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div
                                                            class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-08.jpg"
                                                                    alt="AI and Marketing: Unlocking Customer Insights"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-4">
                            <div class="block-layout list-layout vstack gap-2 lg:gap-3 panel overflow-hidden">
                                <div class="block-header panel pt-1 border-top">
                                    <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">
                                        <a class="hstack d-inline-flex gap-0 text-none hover:text-primary duration-150"
                                            href="blog-category.html">
                                            <span>Arts & Entertainments</span>
                                            <i class="icon-1 fw-bold unicon-chevron-right"></i>
                                        </a>
                                    </h2>
                                </div>
                                <div class="block-content">
                                    <div class="row child-cols-12 g-2 lg:g-4 sep-x" data-uc-grid>
                                        <div>
                                            <article
                                                class="post type-post panel uc-transition-toggle vstack gap-2 lg:gap-3 overflow-hidden uc-dark">
                                                <div class="post-media panel overflow-hidden">
                                                    <div
                                                        class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-4x3">
                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                            src="../assets/images/common/img-fallback.png"
                                                            data-src="../assets/images/demo-seven/posts/img-09.jpg"
                                                            alt="Hidden Gems: Underrated Travel Destinations Around the World"
                                                            data-uc-img="loading: lazy">
                                                    </div>
                                                </div>
                                                <div
                                                    class="position-cover bg-gradient-to-t from-black to-transparent opacity-90">
                                                </div>
                                                <div
                                                    class="post-header panel vstack justify-start items-start flex-column-reverse gap-1 p-2 position-cover text-white">
                                                    <div
                                                        class="post-meta panel hstack justify-between fs-7 text-white text-opacity-60 mt-1">
                                                        <div class="meta">
                                                            <div class="hstack gap-2">
                                                                <div>
                                                                    <div class="post-author hstack gap-1">
                                                                        <a href="page-author.html"
                                                                            data-uc-tooltip="David Peterson"><img
                                                                                src="../assets/images/avatars/01.png"
                                                                                alt="David Peterson"
                                                                                class="w-24px h-24px rounded-circle"></a>
                                                                        <a href="page-author.html"
                                                                            class="text-black dark:text-white text-none fw-bold">David
                                                                            Peterson</a>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <a href="#post_comment"
                                                                        class="post-comments text-none hstack gap-narrow">
                                                                        <i class="icon-narrow unicon-chat"></i>
                                                                        <span>15</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="actions">
                                                            <div class="hstack gap-1"></div>
                                                        </div>
                                                    </div>
                                                    <h3
                                                        class="post-title h6 lg:h5 m-0 m-0 max-w-600px text-white text-truncate-2">
                                                        <a class="text-none text-white" href="blog-details.html">Hidden
                                                            Gems: Underrated Travel Destinations Around the World</a>
                                                    </h3>
                                                    <div
                                                        class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                        <span>23d</span>
                                                    </div>
                                                </div>
                                                <a href="blog-details.html" class="position-cover"></a>
                                            </article>
                                        </div>
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle">
                                                <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">Eco-Tourism: Traveling
                                                                    Responsibly and Sustainably</a>
                                                            </h3>
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>29d</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div
                                                            class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-10.jpg"
                                                                    alt="Eco-Tourism: Traveling Responsibly and Sustainably"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle">
                                                <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">Solo Travel: Some Tips and
                                                                    Destinations for the Adventurous Explorer</a>
                                                            </h3>
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>2mo</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div
                                                            class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-11.jpg"
                                                                    alt="Solo Travel: Some Tips and Destinations for the Adventurous Explorer"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle">
                                                <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                    <div>
                                                        <div class="post-header panel vstack justify-between gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150"
                                                                    href="blog-details.html">AI-Powered Financial
                                                                    Planning: How Algorithms Revolutionizing</a>
                                                            </h3>
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>2mo</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-auto">
                                                        <div
                                                            class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-seven/posts/img-12.jpg"
                                                                    alt="AI-Powered Financial Planning: How Algorithms Revolutionizing"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="blog-details.html" class="position-cover"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Section end -->

    <!-- Section start -->
    <div id="live_now" class="live_now section panel uc-dark swiper-parent">
        <div class="section-outer panel py-4 lg:py-6 bg-gray-900 text-white">
            <div class="container max-w-xl">
                <div
                    class="block-layout slider-thumbs-layout slider-thumbs panel vstack gap-2 lg:gap-3 panel overflow-hidden">
                    <div class="block-header panel">
                        <h2
                            class="h6 ft-tertiary fw-bold ls-0 text-uppercase hstack gap-narrow m-0 text-black dark:text-white">
                            <i class="icon-1 fw-bold unicon-dot-mark text-red" data-uc-animate="flash"></i>
                            <span>Live now</span>
                        </h2>
                    </div>
                    <div class="block-content">
                        <div class="row child-cols-12 g-2" data-uc-grid>
                            <div class="md:col-8 lg:col-9">
                                <div class="panel overflow-hidden rounded">
                                    <div class="swiper swiper-main"
                                        data-uc-swiper="connect: .swiper-thumbs; items: 1; gap: 8; autoplay: 7000; parallax: true; fade: true; effect: fade; dots: .swiper-pagination; disable-class: last-slide;">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <article
                                                    class="post type-post h-250px md:h-350px lg:h-500px bg-black uc-dark">
                                                    <div class="post-media panel overflow-hidden position-cover">
                                                        <div class="featured-video bg-gray-700 ratio ratio-3x2">
                                                            <video class="video-cover video-lazyload min-h-100px"
                                                                preload="none" loop playsinline>
                                                                <source src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-two/videos/vid-01.webm"
                                                                    type="video/webm">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="position-cover bg-gradient-to-t from-black to-transparent z-1 opacity-80">
                                                    </div>
                                                    <div
                                                        class="post-header panel position-absolute bottom-0 vstack justify-between gap-2 xl:gap-4 max-300px lg:max-w-600px p-2 md:p-4 xl:p-6 z-1">
                                                        <h3 class="post-title h4 lg:h3 xl:h2 m-0 text-truncate-2"
                                                            data-swiper-parallax-x="-8">
                                                            <a class="text-none" href="blog-details.html">Balancing Work
                                                                and Wellness: Tech Solutions for Healthy</a>
                                                        </h3>
                                                        <div data-swiper-parallax-x="8">
                                                            <div
                                                                class="post-meta panel hstack justify-between fs-7 fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <div class="meta">
                                                                    <div class="hstack gap-2">
                                                                        <div>
                                                                            <div class="post-author hstack gap-1">
                                                                                <a href="page-author.html"
                                                                                    data-uc-tooltip="Sarah Eddrissi"><img
                                                                                        src="../assets/images/avatars/03.png"
                                                                                        alt="Sarah Eddrissi"
                                                                                        class="w-24px h-24px rounded-circle"></a>
                                                                                <a href="page-author.html"
                                                                                    class="text-black dark:text-white text-none fw-bold">Sarah
                                                                                    Eddrissi</a>
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <div class="post-date hstack gap-narrow">
                                                                                <span>1h ago</span>
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <a href="#post_comment"
                                                                                class="post-comments text-none hstack gap-narrow">
                                                                                <i class="icon-narrow unicon-chat"></i>
                                                                                <span>0</span>
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
                                                </article>
                                            </div>
                                            <div class="swiper-slide">
                                                <article
                                                    class="post type-post h-250px md:h-350px lg:h-500px bg-black uc-dark">
                                                    <div class="post-media panel overflow-hidden position-cover">
                                                        <div class="featured-video bg-gray-700 ratio ratio-3x2">
                                                            <video class="video-cover video-lazyload min-h-100px"
                                                                preload="none" loop playsinline>
                                                                <source src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-two/videos/vid-03.webm"
                                                                    type="video/webm">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="position-cover bg-gradient-to-t from-black to-transparent z-1 opacity-80">
                                                    </div>
                                                    <div
                                                        class="post-header panel position-absolute bottom-0 vstack justify-between gap-2 xl:gap-4 max-300px lg:max-w-600px p-2 md:p-4 xl:p-6 z-1">
                                                        <h3 class="post-title h4 lg:h3 xl:h2 m-0 text-truncate-2"
                                                            data-swiper-parallax-x="-8">
                                                            <a class="text-none" href="blog-details.html">Business
                                                                Agility the Digital Age: Leveraging AI and Automation</a>
                                                        </h3>
                                                        <div data-swiper-parallax-x="8">
                                                            <div
                                                                class="post-meta panel hstack justify-between fs-7 fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <div class="meta">
                                                                    <div class="hstack gap-2">
                                                                        <div>
                                                                            <div class="post-author hstack gap-1">
                                                                                <a href="page-author.html"
                                                                                    data-uc-tooltip="Nisi Nyung"><img
                                                                                        src="../assets/images/avatars/08.png"
                                                                                        alt="Nisi Nyung"
                                                                                        class="w-24px h-24px rounded-circle"></a>
                                                                                <a href="page-author.html"
                                                                                    class="text-black dark:text-white text-none fw-bold">Nisi
                                                                                    Nyung</a>
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <div class="post-date hstack gap-narrow">
                                                                                <span>7d ago</span>
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <a href="#post_comment"
                                                                                class="post-comments text-none hstack gap-narrow">
                                                                                <i class="icon-narrow unicon-chat"></i>
                                                                                <span>23</span>
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
                                                </article>
                                            </div>
                                            <div class="swiper-slide">
                                                <article
                                                    class="post type-post h-250px md:h-350px lg:h-500px bg-black uc-dark">
                                                    <div class="post-media panel overflow-hidden position-cover">
                                                        <div class="featured-video bg-gray-700 ratio ratio-3x2">
                                                            <video class="video-cover video-lazyload min-h-100px"
                                                                preload="none" loop playsinline>
                                                                <source src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-two/videos/vid-04.webm"
                                                                    type="video/webm">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="position-cover bg-gradient-to-t from-black to-transparent z-1 opacity-80">
                                                    </div>
                                                    <div
                                                        class="post-header panel position-absolute bottom-0 vstack justify-between gap-2 xl:gap-4 max-300px lg:max-w-600px p-2 md:p-4 xl:p-6 z-1">
                                                        <h3 class="post-title h4 lg:h3 xl:h2 m-0 text-truncate-2"
                                                            data-swiper-parallax-x="-8">
                                                            <a class="text-none" href="blog-details.html">The Art of
                                                                Baking: From Classic Bread to Artisan Pastries</a>
                                                        </h3>
                                                        <div data-swiper-parallax-x="8">
                                                            <div
                                                                class="post-meta panel hstack justify-between fs-7 fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <div class="meta">
                                                                    <div class="hstack gap-2">
                                                                        <div>
                                                                            <div class="post-author hstack gap-1">
                                                                                <a href="page-author.html"
                                                                                    data-uc-tooltip="Nisi Nyung"><img
                                                                                        src="../assets/images/avatars/08.png"
                                                                                        alt="Nisi Nyung"
                                                                                        class="w-24px h-24px rounded-circle"></a>
                                                                                <a href="page-author.html"
                                                                                    class="text-black dark:text-white text-none fw-bold">Nisi
                                                                                    Nyung</a>
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <div class="post-date hstack gap-narrow">
                                                                                <span>9d ago</span>
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <a href="#post_comment"
                                                                                class="post-comments text-none hstack gap-narrow">
                                                                                <i class="icon-narrow unicon-chat"></i>
                                                                                <span>112</span>
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
                                                </article>
                                            </div>
                                            <div class="swiper-slide">
                                                <article
                                                    class="post type-post h-250px md:h-350px lg:h-500px bg-black uc-dark">
                                                    <div class="post-media panel overflow-hidden position-cover">
                                                        <div class="featured-video bg-gray-700 ratio ratio-3x2">
                                                            <video class="video-cover video-lazyload min-h-100px"
                                                                preload="none" loop playsinline>
                                                                <source src="../assets/images/common/img-fallback.png"
                                                                    data-src="../assets/images/demo-two/videos/vid-05.webm"
                                                                    type="video/webm">
                                                                Your browser does not support the video tag.
                                                            </video>
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="position-cover bg-gradient-to-t from-black to-transparent z-1 opacity-80">
                                                    </div>
                                                    <div
                                                        class="post-header panel position-absolute bottom-0 vstack justify-between gap-2 xl:gap-4 max-300px lg:max-w-600px p-2 md:p-4 xl:p-6 z-1">
                                                        <h3 class="post-title h4 lg:h3 xl:h2 m-0 text-truncate-2"
                                                            data-swiper-parallax-x="-8">
                                                            <a class="text-none" href="blog-details.html">AI-Powered
                                                                Financial Planning: How Algorithms Revolutionizing</a>
                                                        </h3>
                                                        <div data-swiper-parallax-x="8">
                                                            <div
                                                                class="post-meta panel hstack justify-between fs-7 fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <div class="meta">
                                                                    <div class="hstack gap-2">
                                                                        <div>
                                                                            <div class="post-author hstack gap-1">
                                                                                <a href="page-author.html"
                                                                                    data-uc-tooltip="Sarah Eddrissi"><img
                                                                                        src="../assets/images/avatars/03.png"
                                                                                        alt="Sarah Eddrissi"
                                                                                        class="w-24px h-24px rounded-circle"></a>
                                                                                <a href="page-author.html"
                                                                                    class="text-black dark:text-white text-none fw-bold">Sarah
                                                                                    Eddrissi</a>
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <div class="post-date hstack gap-narrow">
                                                                                <span>2mo ago</span>
                                                                            </div>
                                                                        </div>
                                                                        <div>
                                                                            <a href="#post_comment"
                                                                                class="post-comments text-none hstack gap-narrow">
                                                                                <i class="icon-narrow unicon-chat"></i>
                                                                                <span>2</span>
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
                                                </article>
                                            </div>
                                        </div>

                                        <!-- Add Pagination -->
                                        <div
                                            class="swiper-pagination top-auto start-auto bottom-0 end-0 m-2 md:m-4 xl:m-6 text-white d-none md:d-inline-flex justify-end w-auto">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="md:col-4 lg:col-3">
                                <div class="panel md:vstack gap-1 h-100">

                                    <!-- Slides thumbs -->
                                    <div class="swiper swiper-thumbs swiper-thumbs-progress rounded order-2"
                                        data-uc-swiper="items: 2;
                            gap: 4; 
                            disable-class: last-slide;"
                                        data-uc-swiper-s="items: auto;
                            direction: vertical;
                            autoHeight: true;
                            mousewheel: true;
                            freeMode: false;
                            watchSlidesVisibility: true;
                            watchSlidesProgress: true;
                            watchOverflow: true">
                                        <div class="swiper-wrapper md:flex-1">
                                            <div class="swiper-slide overflow-hidden rounded min-h-64px lg:min-h-100px">
                                                <div class="swiper-slide-progress position-cover z-0">
                                                    <span></span>
                                                </div>
                                                <article class="post type-post panel uc-transition-toggle p-1 z-1">
                                                    <div class="row gx-1">
                                                        <div class="col-auto post-media-wrap">
                                                            <div
                                                                class="post-media panel overflow-hidden w-40px lg:w-64px rounded">
                                                                <div class="featured-video bg-gray-700 ratio ratio-3x4">
                                                                    <video class="video-cover video-lazyload min-h-100px"
                                                                        preload="none" loop playsinline>
                                                                        <source
                                                                            src="../assets/images/common/img-fallback.png"
                                                                            data-src="../assets/images/demo-two/videos/vid-01.webm"
                                                                            type="video/webm">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                </div>
                                                                <div
                                                                    class="has-video-overlay position-absolute top-0 end-0 w-40px h-40px lg:w-64px lg:h-64px bg-gradient-45 from-transparent via-transparent to-black opacity-50">
                                                                </div>
                                                                <span
                                                                    class="cstack has-video-icon position-absolute top-50 start-50 translate-middle fs-6 w-40px h-40px text-white">
                                                                    <i class="icon-narrow unicon-play-filled-alt"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <p
                                                                class="fs-6 m-0 text-truncate-2 text-gray-900 dark:text-white">
                                                                Balancing Work and Wellness: Tech Solutions for Healthy</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div class="swiper-slide overflow-hidden rounded min-h-64px lg:min-h-100px">
                                                <div class="swiper-slide-progress position-cover z-0">
                                                    <span></span>
                                                </div>
                                                <article class="post type-post panel uc-transition-toggle p-1 z-1">
                                                    <div class="row gx-1">
                                                        <div class="col-auto post-media-wrap">
                                                            <div
                                                                class="post-media panel overflow-hidden w-40px lg:w-64px rounded">
                                                                <div class="featured-video bg-gray-700 ratio ratio-3x4">
                                                                    <video class="video-cover video-lazyload min-h-100px"
                                                                        preload="none" loop playsinline>
                                                                        <source
                                                                            src="../assets/images/common/img-fallback.png"
                                                                            data-src="../assets/images/demo-two/videos/vid-03.webm"
                                                                            type="video/webm">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                </div>
                                                                <div
                                                                    class="has-video-overlay position-absolute top-0 end-0 w-40px h-40px lg:w-64px lg:h-64px bg-gradient-45 from-transparent via-transparent to-black opacity-50">
                                                                </div>
                                                                <span
                                                                    class="cstack has-video-icon position-absolute top-50 start-50 translate-middle fs-6 w-40px h-40px text-white">
                                                                    <i class="icon-narrow unicon-play-filled-alt"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <p
                                                                class="fs-6 m-0 text-truncate-2 text-gray-900 dark:text-white">
                                                                Business Agility the Digital Age: Leveraging AI and
                                                                Automation</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div class="swiper-slide overflow-hidden rounded min-h-64px lg:min-h-100px">
                                                <div class="swiper-slide-progress position-cover z-0">
                                                    <span></span>
                                                </div>
                                                <article class="post type-post panel uc-transition-toggle p-1 z-1">
                                                    <div class="row gx-1">
                                                        <div class="col-auto post-media-wrap">
                                                            <div
                                                                class="post-media panel overflow-hidden w-40px lg:w-64px rounded">
                                                                <div class="featured-video bg-gray-700 ratio ratio-3x4">
                                                                    <video class="video-cover video-lazyload min-h-100px"
                                                                        preload="none" loop playsinline>
                                                                        <source
                                                                            src="../assets/images/common/img-fallback.png"
                                                                            data-src="../assets/images/demo-two/videos/vid-04.webm"
                                                                            type="video/webm">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                </div>
                                                                <div
                                                                    class="has-video-overlay position-absolute top-0 end-0 w-40px h-40px lg:w-64px lg:h-64px bg-gradient-45 from-transparent via-transparent to-black opacity-50">
                                                                </div>
                                                                <span
                                                                    class="cstack has-video-icon position-absolute top-50 start-50 translate-middle fs-6 w-40px h-40px text-white">
                                                                    <i class="icon-narrow unicon-play-filled-alt"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <p
                                                                class="fs-6 m-0 text-truncate-2 text-gray-900 dark:text-white">
                                                                The Art of Baking: From Classic Bread to Artisan Pastries
                                                            </p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div class="swiper-slide overflow-hidden rounded min-h-64px lg:min-h-100px">
                                                <div class="swiper-slide-progress position-cover z-0">
                                                    <span></span>
                                                </div>
                                                <article class="post type-post panel uc-transition-toggle p-1 z-1">
                                                    <div class="row gx-1">
                                                        <div class="col-auto post-media-wrap">
                                                            <div
                                                                class="post-media panel overflow-hidden w-40px lg:w-64px rounded">
                                                                <div class="featured-video bg-gray-700 ratio ratio-3x4">
                                                                    <video class="video-cover video-lazyload min-h-100px"
                                                                        preload="none" loop playsinline>
                                                                        <source
                                                                            src="../assets/images/common/img-fallback.png"
                                                                            data-src="../assets/images/demo-two/videos/vid-05.webm"
                                                                            type="video/webm">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                </div>
                                                                <div
                                                                    class="has-video-overlay position-absolute top-0 end-0 w-40px h-40px lg:w-64px lg:h-64px bg-gradient-45 from-transparent via-transparent to-black opacity-50">
                                                                </div>
                                                                <span
                                                                    class="cstack has-video-icon position-absolute top-50 start-50 translate-middle fs-6 w-40px h-40px text-white">
                                                                    <i class="icon-narrow unicon-play-filled-alt"></i>
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <p
                                                                class="fs-6 m-0 text-truncate-2 text-gray-900 dark:text-white">
                                                                AI-Powered Financial Planning: How Algorithms
                                                                Revolutionizing</p>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tablet, Desktop and big screens nav -->
                                    <div
                                        class="swiper-prev btn btn-2xs lg:btn-xs btn-primary w-100 d-none md:d-flex order-1">
                                        Prev</div>
                                    <div
                                        class="swiper-next btn btn-2xs lg:btn-xs btn-primary w-100 d-none md:d-flex order-3">
                                        Next</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Section end -->

    <!-- Section start -->
    <div id="latest_news" class="latest-news section panel">
        <div class="section-outer panel py-4 lg:py-6">
            <div class="container max-w-xl">
                <div class="section-inner">
                    <div class="content-wrap row child-cols-12 g-4 lg:g-6" data-uc-grid>
                        <div class="md:col-9">
                            <div class="main-wrap panel vstack gap-3 lg:gap-6">
                                <div class="block-layout grid-layout vstack gap-2 panel overflow-hidden">
                                    <div class="block-header panel pt-1 border-top">
                                        <h2
                                            class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">
                                            Latest</h2>
                                    </div>
                                    <div class="block-content">
                                        <div class="row child-cols-12 g-2 lg:g-4 sep-x">
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-01.jpg"
                                                                        alt="The Rise of AI-Powered Personal Assistants: How They Manage"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">The Rise of AI-Powered
                                                                        Personal Assistants: How They Manage</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                Law enforcement officers have been accused of sexually
                                                                abusing children over the past two decades, a Post
                                                                investigation found. Nisi dignissim tortor sed quam sed
                                                                ipsum ut. Dolor sit amet, consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-02.jpg"
                                                                        alt="Tech Innovations Reshaping the Retail Landscape: AI Payments"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">Tech Innovations
                                                                        Reshaping the Retail Landscape: AI Payments</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                Officers have been accused of sexually abusing children over
                                                                the past two decades, a Post investigation found. Nisi
                                                                dignissim tortor sed quam sed ipsum ut. Dolor sit amet,
                                                                consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-03.jpg"
                                                                        alt="Balancing Work and Wellness: Tech Solutions for Healthy"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">Balancing Work and
                                                                        Wellness: Tech Solutions for Healthy</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                Children over the past two decades, a Post investigation
                                                                found. Nisi dignissim tortor sed quam sed ipsum ut. Dolor
                                                                sit amet, consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-04.jpg"
                                                                        alt="The Importance of Sleep: Tips for Better Rest and Recovery"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">The Importance of Sleep:
                                                                        Tips for Better Rest and Recovery</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                Post investigation found. Nisi dignissim tortor sed quam sed
                                                                ipsum ut. Dolor sit amet, consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-05.jpg"
                                                                        alt="The Future of Sustainable Living: Driving Eco-Friendly Lifestyles"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">The Future of Sustainable
                                                                        Living: Driving Eco-Friendly Lifestyles</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                Nisi dignissim tortor sed quam sed ipsum ut. Dolor sit amet,
                                                                consectetur adipiscing elit To spread the word, the company
                                                                embarked on a mass marketing drive. TV campaigns launched in
                                                                the platform’s key markets.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-06.jpg"
                                                                        alt="Business Agility the Digital Age: Leveraging AI and Automation"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">Business Agility the
                                                                        Digital Age: Leveraging AI and Automation</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                To spread the word, the company embarked on a mass marketing
                                                                drive. TV campaigns launched in the platform’s key markets.
                                                                Nisi dignissim tortor sed quam sed ipsum ut. Dolor sit amet,
                                                                consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-07.jpg"
                                                                        alt="The Art of Baking: From Classic Bread to Artisan Pastries"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">The Art of Baking: From
                                                                        Classic Bread to Artisan Pastries</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                To spread the word, the company embarked on a mass marketing
                                                                drive. TV campaigns launched in the platform’s key markets.
                                                                Nisi dignissim tortor sed quam sed ipsum ut. Dolor sit amet,
                                                                consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-08.jpg"
                                                                        alt="AI and Marketing: Unlocking Customer Insights"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">AI and Marketing:
                                                                        Unlocking Customer Insights</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                To spread the word, the company embarked on a mass marketing
                                                                drive. TV campaigns launched in the platform’s key markets.
                                                                Nisi dignissim tortor sed quam sed ipsum ut. Dolor sit amet,
                                                                consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-09.jpg"
                                                                        alt="Hidden Gems: Underrated Travel Destinations Around the World"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">Hidden Gems: Underrated
                                                                        Travel Destinations Around the World</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                To spread the word, the company embarked on a mass marketing
                                                                drive. TV campaigns launched in the platform’s key markets.
                                                                Nisi dignissim tortor sed quam sed ipsum ut. Dolor sit amet,
                                                                consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-10.jpg"
                                                                        alt="Eco-Tourism: Traveling Responsibly and Sustainably"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">Eco-Tourism: Traveling
                                                                        Responsibly and Sustainably</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                To spread the word, the company embarked on a mass marketing
                                                                drive. TV campaigns launched in the platform’s key markets.
                                                                Nisi dignissim tortor sed quam sed ipsum ut. Dolor sit amet,
                                                                consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-11.jpg"
                                                                        alt="Solo Travel: Some Tips and Destinations for the Adventurous Explorer"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">Solo Travel: Some Tips
                                                                        and Destinations for the Adventurous Explorer</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                To spread the word, the company embarked on a mass marketing
                                                                drive. TV campaigns launched in the platform’s key markets.
                                                                Nisi dignissim tortor sed quam sed ipsum ut. Dolor sit amet,
                                                                consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div
                                                                class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                <div
                                                                    class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="../assets/images/common/img-fallback.png"
                                                                        data-src="../assets/images/demo-seven/posts/img-12.jpg"
                                                                        alt="AI-Powered Financial Planning: How Algorithms Revolutionizing"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="blog-details.html" class="position-cover"></a>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="blog-details.html">AI-Powered Financial
                                                                        Planning: How Algorithms Revolutionizing</a>
                                                                </h3>
                                                            </div>
                                                            <p
                                                                class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">
                                                                To spread the word, the company embarked on a mass marketing
                                                                drive. TV campaigns launched in the platform’s key markets.
                                                                Nisi dignissim tortor sed quam sed ipsum ut. Dolor sit amet,
                                                                consectetur adipiscing elit.</p>
                                                            <div class="post-link">
                                                                <a href="blog-details.html"
                                                                    class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                    <span>Read more</span>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </article>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="block-footer cstack lg:mt-2">
                                        <a href="#"
                                            class="animate-btn gap-0 btn btn-sm btn-alt-primary bg-transparent text-black dark:text-white border w-100">
                                            <span>Load more posts</span>
                                            <i class="icon icon-1 unicon-chevron-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="md:col-3">
                            <div class="sidebar-wrap panel vstack gap-2 pb-2"
                                data-uc-sticky="end: .content-wrap; offset: 150; media: @m;">
                                <div class="widget ad-widget vstack gap-2 text-center p-2 border">
                                    <div class="widgt-content">
                                        <a class="cstack max-w-300px mx-auto text-none"
                                            href="https://themeforest.net/user/reacthemes/portfolio" target="_blank"
                                            rel="nofollow">
                                            <img class="d-block dark:d-none"
                                                src="../assets/images/common/ad-slot-aside.jpg" alt="Ad slot">
                                            <img class="d-none dark:d-block"
                                                src="../assets/images/common/ad-slot-aside-2.jpg" alt="Ad slot">
                                        </a>
                                    </div>
                                </div>
                                <div class="widget popular-widget vstack gap-2 p-2 border">
                                    <div class="widget-title text-center">
                                        <h5 class="fs-7 ft-tertiary text-uppercase m-0">Popular now</h5>
                                    </div>
                                    <div class="widget-content">
                                        <div class="row child-cols-12 gx-4 gy-3 sep-x" data-uc-grid>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div>
                                                            <div class="hstack items-start gap-3">
                                                                <span
                                                                    class="h3 lg:h2 ft-tertiary fst-italic text-center text-primary m-0 min-w-24px">1</span>
                                                                <div
                                                                    class="post-header panel vstack justify-between gap-1">
                                                                    <h3 class="post-title h6 m-0">
                                                                        <a class="text-none hover:text-primary duration-150"
                                                                            href="blog-details.html">Virtual Reality and
                                                                            Mental Health: Exploring the Therapeutic</a>
                                                                    </h3>
                                                                    <div
                                                                        class="post-meta panel hstack justify-between fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                        <div class="meta">
                                                                            <div class="hstack gap-2">
                                                                                <div>
                                                                                    <div
                                                                                        class="post-date hstack gap-narrow">
                                                                                        <span>2mo ago</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#post_comment"
                                                                                        class="post-comments text-none hstack gap-narrow">
                                                                                        <i
                                                                                            class="icon-narrow unicon-chat"></i>
                                                                                        <span>290</span>
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
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div>
                                                            <div class="hstack items-start gap-3">
                                                                <span
                                                                    class="h3 lg:h2 ft-tertiary fst-italic text-center text-primary m-0 min-w-24px">2</span>
                                                                <div
                                                                    class="post-header panel vstack justify-between gap-1">
                                                                    <h3 class="post-title h6 m-0">
                                                                        <a class="text-none hover:text-primary duration-150"
                                                                            href="blog-details.html">The Future of
                                                                            Sustainable Living: Driving Eco-Friendly
                                                                            Lifestyles</a>
                                                                    </h3>
                                                                    <div
                                                                        class="post-meta panel hstack justify-between fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                        <div class="meta">
                                                                            <div class="hstack gap-2">
                                                                                <div>
                                                                                    <div
                                                                                        class="post-date hstack gap-narrow">
                                                                                        <span>2mo ago</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#post_comment"
                                                                                        class="post-comments text-none hstack gap-narrow">
                                                                                        <i
                                                                                            class="icon-narrow unicon-chat"></i>
                                                                                        <span>1</span>
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
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div>
                                                            <div class="hstack items-start gap-3">
                                                                <span
                                                                    class="h3 lg:h2 ft-tertiary fst-italic text-center text-primary m-0 min-w-24px">3</span>
                                                                <div
                                                                    class="post-header panel vstack justify-between gap-1">
                                                                    <h3 class="post-title h6 m-0">
                                                                        <a class="text-none hover:text-primary duration-150"
                                                                            href="blog-details.html">Smart Homes, Smarter
                                                                            Living: Exploring IoT and AI</a>
                                                                    </h3>
                                                                    <div
                                                                        class="post-meta panel hstack justify-between fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                        <div class="meta">
                                                                            <div class="hstack gap-2">
                                                                                <div>
                                                                                    <div
                                                                                        class="post-date hstack gap-narrow">
                                                                                        <span>23d ago</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#post_comment"
                                                                                        class="post-comments text-none hstack gap-narrow">
                                                                                        <i
                                                                                            class="icon-narrow unicon-chat"></i>
                                                                                        <span>15</span>
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
                                                    </div>
                                                </article>
                                            </div>
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div>
                                                            <div class="hstack items-start gap-3">
                                                                <span
                                                                    class="h3 lg:h2 ft-tertiary fst-italic text-center text-primary m-0 min-w-24px">4</span>
                                                                <div
                                                                    class="post-header panel vstack justify-between gap-1">
                                                                    <h3 class="post-title h6 m-0">
                                                                        <a class="text-none hover:text-primary duration-150"
                                                                            href="blog-details.html">How Businesses Are
                                                                            Adapting to E-Commerce and AI Integration</a>
                                                                    </h3>
                                                                    <div
                                                                        class="post-meta panel hstack justify-between fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                        <div class="meta">
                                                                            <div class="hstack gap-2">
                                                                                <div>
                                                                                    <div
                                                                                        class="post-date hstack gap-narrow">
                                                                                        <span>29d ago</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#post_comment"
                                                                                        class="post-comments text-none hstack gap-narrow">
                                                                                        <i
                                                                                            class="icon-narrow unicon-chat"></i>
                                                                                        <span>20</span>
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
                                                    </div>
                                                </article>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="widget social-widget vstack gap-2 text-center p-2 border">
                                    <div class="widgt-title">
                                        <h4 class="fs-7 ft-tertiary text-uppercase m-0">Follow @News5</h4>
                                    </div>
                                    <div class="widgt-content">
                                        <form class="vstack gap-1">
                                            <input
                                                class="form-control form-control-sm fs-6 fw-medium h-40px w-full bg-white dark:bg-gray-800 dark:bg-gray-800 dark:border-white dark:border-opacity-15 dark:border-opacity-15"
                                                type="email" placeholder="Your email" required="">
                                            <button class="btn btn-sm btn-primary" type="submit">Sign up</button>
                                        </form>
                                        <ul class="nav-x justify-center gap-1 mt-3">
                                            <li>
                                                <a href="#fb"
                                                    class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150"><i
                                                        class="icon icon-1 unicon-logo-facebook"></i></a>
                                            </li>
                                            <li>
                                                <a href="#x"
                                                    class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150"><i
                                                        class="icon icon-1 unicon-logo-x-filled"></i></a>
                                            </li>
                                            <li>
                                                <a href="#in"
                                                    class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150"><i
                                                        class="icon icon-1 unicon-logo-instagram"></i></a>
                                            </li>
                                            <li>
                                                <a href="#yt"
                                                    class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150"><i
                                                        class="icon icon-1 unicon-logo-youtube"></i></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Section end -->
@endsection

@section('script')

@endsection
