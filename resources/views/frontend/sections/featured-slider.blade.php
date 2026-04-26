{{-- resources/views/frontend/sections/featured-slider.blade.php --}}
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
                                    @if($featuredPosts->count() > 0)
                                        <div class="swiper"
                                            data-uc-swiper="items: 1; active: 1; gap: 4; prev: .nav-prev; next: .nav-next; autoplay: 6000; parallax: true; fade: true; effect: fade; disable-class: d-none;">
                                            <div class="swiper-wrapper">
                                                @foreach($featuredPosts as $post)
                                                <div class="swiper-slide">
                                                    <article
                                                        class="post type-post panel uc-transition-toggle vstack gap-2 lg:gap-3 h-100 overflow-hidden uc-dark">
                                                        <div class="post-media panel overflow-hidden h-100">
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 h-100 d-none md:d-block">
                                                                <canvas class="h-100 w-100"></canvas>
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="{{ asset('assets/img/blog/blog-default.png') }}"
                                                                    data-src="{{ $post->main_image ? asset($post->main_image) : asset('assets/img/blog/blog-default.png') }}"
                                                                    alt="{{ $post->title }}"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                            <div
                                                                class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-16x9 d-block md:d-none">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                    src="{{ asset('assets/img/blog/blog-default.png') }}"
                                                                    data-src="{{ $post->main_image ? asset($post->main_image) : asset('assets/img/blog/blog-default.png') }}"
                                                                    alt="{{ $post->title }}"
                                                                    data-uc-img="loading: lazy">
                                                            </div>
                                                        </div>
                                                        <div
                                                            class="position-cover bg-gradient-to-t from-black to-transparent opacity-90">
                                                        </div>
                                                        <div class="post-header panel vstack justify-end items-start gap-1 p-2 sm:p-4 position-cover text-white"
                                                            data-swiper-parallax-y="-24">
                                                            <div
                                                                class="post-category hstack gap-narrow fs-7 text-white text-opacity-60">
                                                                <span class="badge bg-primary p-1">{{ $post->category->name ?? 'Uncategorized' }}</span>
                                                            </div>
                                                            <div
                                                                class="post-date hstack gap-narrow fs-7 text-white text-opacity-60 d-none md:d-flex">
                                                                <i class="unicon-calendar"></i>
                                                                <span>{{ $post->published_at->format('M d, Y') }}</span>
                                                            </div>
                                                            <h3
                                                                class="post-title h5 lg:h4 xl:h3 m-0 max-w-600px text-white text-truncate-2">
                                                                <a class="text-none text-white"
                                                                    href="{{ route('frontend.post.details', $post->slug) }}">
                                                                    {{ $post->title }}
                                                                </a>
                                                            </h3>
                                                            <div>
                                                                <div
                                                                    class="post-meta panel hstack justify-between fs-7 text-white text-opacity-60 mt-1">
                                                                    <div class="meta">
                                                                        <div class="hstack gap-3">
                                                                            <div>
                                                                                <div class="post-author hstack gap-1">
                                                                                    @if($post->author && $post->author->image)
                                                                                        <img src="{{ asset($post->author->image) }}"
                                                                                            alt="{{ $post->author->name }}"
                                                                                            class="w-24px h-24px rounded-circle">
                                                                                    @else
                                                                                        <img src="{{ asset('assets/img/default/user-default.webp') }}"
                                                                                            class="w-24px h-24px rounded-circle"
                                                                                            alt="Default User">
                                                                                    @endif
                                                                                    <a href="#" class="text-white text-none fw-bold">
                                                                                        {{ $post->author->name ?? 'Admin' }}
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                            <div class="hstack gap-2">
                                                                                <div class="hstack gap-1">
                                                                                    <i class="unicon-favorite"></i>
                                                                                    <span>{{ $post->likes_count ?? 0 }}</span>
                                                                                </div>
                                                                                <div class="hstack gap-1">
                                                                                    <i class="unicon-chat"></i>
                                                                                    <span>{{ $post->comments_count ?? 0 }}</span>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                                @endforeach
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
                                    @else
                                        <div class="text-center py-5">
                                            <i class="unicon-image fs-1 text-gray-400"></i>
                                            <p class="mt-3 text-gray-500">No featured posts available</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-3">
                            <div class="panel cstack gap-2 h-100">
                                <div>
                                    <div class="widget ad-widget vstack gap-2">
                                        <div class="widget-title text-center">
                                            <h5 class="fs-7 ft-tertiary text-uppercase m-0">Sponsor</h5>
                                        </div>
                                        <div class="widget-content">
                                            <a class="cstack max-w-300px mx-auto text-none"
                                                href="https://siteffects.com"
                                                target="_blank" rel="nofollow">
                                                <img class="d-none sm:d-block"
                                                    src="{{ asset('front/images/common/ad-desktop.jpg') }}" alt="Ad slot">
                                                <img class="d-block sm:d-none"
                                                    src="{{ asset('front/images/common/ad-slot-mobile.jpg') }}" alt="Ad slot">
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