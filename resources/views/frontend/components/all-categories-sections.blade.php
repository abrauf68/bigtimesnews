@props(['categories'])

@php
    $categoriesArray = $categories->values();
    $firstCategory = $categoriesArray[0] ?? null;
    $secondCategory = $categoriesArray[1] ?? null;
    $remainingCategories = $categoriesArray->slice(2);
@endphp

<!-- First Row: Large Category + Sidebar Category -->
<div class="section panel overflow-hidden">
    <div class="section-outer panel">
        <div class="container max-w-xl">
            <div class="section-inner">
                <div class="row child-cols-12 lg:child-cols g-4 lg:g-6 col-match" data-uc-grid>
                    
                    <!-- First Category (Large Layout - Like Opinions) -->
                    @if($firstCategory)
                    <div class="lg:col-8 order-0 lg:order-2">
                        <div class="block-layout grid-layout vstack gap-2 lg:gap-3 panel overflow-hidden">
                            <div class="block-header panel pt-1 border-top">
                                <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">
                                    <a class="hstack d-inline-flex gap-0 text-none hover:text-primary duration-150"
                                        href="{{ route('frontend.category', $firstCategory->slug) }}">
                                        <span>{{ $firstCategory->name }}</span>
                                        <i class="icon-1 fw-bold unicon-chevron-right"></i>
                                    </a>
                                </h2>
                            </div>
                            <div class="block-content">
                                <div class="panel row child-cols-12 md:child-cols g-2 lg:g-4 col-match sep-y" data-uc-grid>
                                    <!-- Featured Post -->
                                    <div class="col-12 md:col-6 order-0 md:order-1">
                                        @php $featuredPost = $firstCategory->posts->first(); @endphp
                                        @if($featuredPost)
                                        <div>
                                            <article class="post type-post panel uc-transition-toggle vstack gap-2 lg:gap-3 h-100 overflow-hidden uc-dark">
                                                <div class="post-media panel overflow-hidden h-100">
                                                    <div class="featured-image bg-gray-25 dark:bg-gray-800 h-100 d-none md:d-block">
                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                            src="{{ asset('assets/img/blog/blog-default.png') }}"
                                                            data-src="{{ $featuredPost->main_image ? asset($featuredPost->main_image) : asset('assets/img/blog/blog-default.png') }}"
                                                            alt="{{ $featuredPost->title }}"
                                                            data-uc-img="loading: lazy"
                                                            style="width:100%; height:100%; object-fit:cover;">
                                                    </div>
                                                    <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-16x9 d-block md:d-none">
                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                            src="{{ asset('assets/img/blog/blog-default.png') }}"
                                                            data-src="{{ $featuredPost->main_image ? asset($featuredPost->main_image) : asset('assets/img/blog/blog-default.png') }}"
                                                            alt="{{ $featuredPost->title }}"
                                                            data-uc-img="loading: lazy">
                                                    </div>
                                                </div>
                                                <div class="position-cover bg-gradient-to-t from-black to-transparent opacity-90"></div>
                                                <div class="post-header panel vstack justify-end items-start gap-1 p-2 sm:p-4 position-cover text-white">
                                                    <div class="post-date hstack gap-narrow fs-7 text-white text-opacity-60">
                                                        <span>{{ $featuredPost->published_at->diffForHumans() }}</span>
                                                    </div>
                                                    <h3 class="post-title h5 lg:h4 m-0 max-w-600px text-white text-truncate-2">
                                                        <a class="text-none text-white" href="{{ route('frontend.post.details', $featuredPost->slug) }}">
                                                            {{ $featuredPost->title }}
                                                        </a>
                                                    </h3>
                                                    <div class="post-meta panel hstack justify-between fs-7 text-white text-opacity-60 mt-1">
                                                        <div class="meta">
                                                            <div class="hstack gap-2">
                                                                <div class="hstack gap-1">
                                                                    <i class="unicon-heart"></i>
                                                                    <span>{{ $featuredPost->likes_count ?? 0 }}</span>
                                                                </div>
                                                                <div class="hstack gap-1">
                                                                    <i class="unicon-chat"></i>
                                                                    <span>{{ $featuredPost->comments_count ?? 0 }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </article>
                                        </div>
                                        @endif
                                    </div>
                                    
                                    <!-- List Posts -->
                                    <div class="order-1 md:order-0">
                                        <div class="row child-cols-12 g-2 lg:g-4 sep-x" data-uc-grid>
                                            @foreach($firstCategory->posts->skip(1)->take(4) as $post)
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle">
                                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h6 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150"
                                                                        href="{{ route('frontend.post.details', $post->slug) }}">
                                                                        {{ $post->title }}
                                                                    </a>
                                                                </h3>
                                                                <div class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60">
                                                                    <span>{{ $post->published_at->diffForHumans() }}</span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-auto">
                                                            <div class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                                <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                        src="{{ asset('assets/img/blog/blog-default.png') }}"
                                                                        data-src="{{ $post->main_image ? asset($post->main_image) : asset('assets/img/blog/blog-default.png') }}"
                                                                        alt="{{ $post->title }}"
                                                                        data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="{{ route('frontend.post.details', $post->slug) }}" class="position-cover"></a>
                                                            </div>
                                                        </div>
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
                    
                    <!-- Second Category (Sidebar Layout - Like World) -->
                    @if($secondCategory)
                    <div class="lg:col-4 order-1">
                        <div class="block-layout grid-layout vstack gap-2 lg:gap-3 panel overflow-hidden">
                            <div class="block-header panel pt-1 border-top">
                                <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">
                                    <a class="hstack d-inline-flex gap-0 text-none hover:text-primary duration-150"
                                        href="{{ route('frontend.category', $secondCategory->slug) }}">
                                        <span>{{ $secondCategory->name }}</span>
                                        <i class="icon-1 fw-bold unicon-chevron-right"></i>
                                    </a>
                                </h2>
                            </div>
                            <div class="block-content">
                                <div class="row child-cols-12 g-2 lg:g-4 sep-x" data-uc-grid>
                                    @foreach($secondCategory->posts->take(4) as $post)
                                    <div>
                                        <article class="post type-post panel uc-transition-toggle">
                                            <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                <div>
                                                    <div class="post-header panel vstack justify-between gap-1">
                                                        <h3 class="post-title h6 m-0 text-truncate-2">
                                                            <a class="text-none hover:text-primary duration-150"
                                                                href="{{ route('frontend.post.details', $post->slug) }}">
                                                                {{ $post->title }}
                                                            </a>
                                                        </h3>
                                                        <div class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60">
                                                            <span>{{ $post->published_at->diffForHumans() }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                        <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                src="{{ asset('assets/img/blog/blog-default.png') }}"
                                                                data-src="{{ $post->main_image ? asset($post->main_image) : asset('assets/img/blog/blog-default.png') }}"
                                                                alt="{{ $post->title }}"
                                                                data-uc-img="loading: lazy">
                                                        </div>
                                                        <a href="{{ route('frontend.post.details', $post->slug) }}" class="position-cover"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Second Row: Remaining Categories (Tech, Business, Arts style) -->
@if($remainingCategories->count() > 0)
<div class="section panel overflow-hidden">
    <div class="section-outer panel py-4 lg:py-6 dark:text-white">
        <div class="container max-w-xl">
            <div class="section-inner">
                <div class="row child-cols-12 lg:child-cols g-4 lg:g-6 col-match" data-uc-grid>
                    @foreach($remainingCategories as $category)
                    <div class="lg:col-4">
                        <div class="block-layout list-layout vstack gap-2 lg:gap-3 panel overflow-hidden">
                            <div class="block-header panel pt-1 border-top">
                                <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">
                                    <a class="hstack d-inline-flex gap-0 text-none hover:text-primary duration-150"
                                        href="{{ route('frontend.category', $category->slug) }}">
                                        <span>{{ $category->name }}</span>
                                        <i class="icon-1 fw-bold unicon-chevron-right"></i>
                                    </a>
                                </h2>
                            </div>
                            <div class="block-content">
                                <div class="row child-cols-12 g-2 lg:g-4 sep-x" data-uc-grid>
                                    @php $firstPost = $category->posts->first(); @endphp
                                    @if($firstPost)
                                    <div>
                                        <article class="post type-post panel uc-transition-toggle vstack gap-2 lg:gap-3 overflow-hidden uc-dark">
                                            <div class="post-media panel overflow-hidden">
                                                <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-4x3">
                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                        src="{{ asset('assets/img/blog/blog-default.png') }}"
                                                        data-src="{{ $firstPost->main_image ? asset($firstPost->main_image) : asset('assets/img/blog/blog-default.png') }}"
                                                        alt="{{ $firstPost->title }}"
                                                        data-uc-img="loading: lazy">
                                                </div>
                                            </div>
                                            <div class="position-cover bg-gradient-to-t from-black to-transparent opacity-90"></div>
                                            <div class="post-header panel vstack justify-start items-start flex-column-reverse gap-1 p-2 position-cover text-white">
                                                <div class="post-meta panel hstack justify-between fs-7 text-white text-opacity-60 mt-1">
                                                    <div class="meta">
                                                        <div class="hstack gap-2">
                                                            <div class="hstack gap-1">
                                                                <i class="unicon-heart"></i>
                                                                <span>{{ $firstPost->likes_count ?? 0 }}</span>
                                                            </div>
                                                            <div class="hstack gap-1">
                                                                <i class="unicon-chat"></i>
                                                                <span>{{ $firstPost->comments_count ?? 0 }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <h3 class="post-title h6 lg:h5 m-0 max-w-600px text-white text-truncate-2">
                                                    <a class="text-none text-white" href="{{ route('frontend.post.details', $firstPost->slug) }}">
                                                        {{ $firstPost->title }}
                                                    </a>
                                                </h3>
                                                <div class="post-date hstack gap-narrow fs-7 text-white text-opacity-60">
                                                    <span>{{ $firstPost->published_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                            <a href="{{ route('frontend.post.details', $firstPost->slug) }}" class="position-cover"></a>
                                        </article>
                                    </div>
                                    @endif
                                    
                                    @foreach($category->posts->skip(1)->take(3) as $post)
                                    <div>
                                        <article class="post type-post panel uc-transition-toggle">
                                            <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                <div>
                                                    <div class="post-header panel vstack justify-between gap-1">
                                                        <h3 class="post-title h6 m-0 text-truncate-2">
                                                            <a class="text-none hover:text-primary duration-150"
                                                                href="{{ route('frontend.post.details', $post->slug) }}">
                                                                {{ $post->title }}
                                                            </a>
                                                        </h3>
                                                        <div class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60">
                                                            <span>{{ $post->published_at->diffForHumans() }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-auto">
                                                    <div class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                        <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                src="{{ asset('assets/img/blog/blog-default.png') }}"
                                                                data-src="{{ $post->main_image ? asset($post->main_image) : asset('assets/img/blog/blog-default.png') }}"
                                                                alt="{{ $post->title }}"
                                                                data-uc-img="loading: lazy">
                                                        </div>
                                                        <a href="{{ route('frontend.post.details', $post->slug) }}" class="position-cover"></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif