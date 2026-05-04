{{-- resources/views/frontend/sections/top-posts.blade.php --}}
<!-- Section start -->
@if($topPosts->count() > 0)
<div class="section panel overflow-hidden swiper-parent border-top">
    <div class="section-outer panel py-2 lg:py-4 dark:text-white">
        <div class="container max-w-xl">
            <div class="section-inner panel vstack gap-2">
                <div class="block-layout carousel-layout vstack gap-2 lg:gap-3 panel">
                    <div class="block-content panel">
                        <div class="swiper"
                            data-uc-swiper="items: 1; gap: 16; dots: .dot-nav; next: .nav-next; prev: .nav-prev; disable-class: d-none;"
                            data-uc-swiper-s="items: 3; gap: 24;"
                            data-uc-swiper-l="items: 4; gap: 24;">
                            <div class="swiper-wrapper">
                                @foreach($topPosts as $post)
                                <div class="swiper-slide">
                                    <div>
                                        <article class="post type-post panel uc-transition-toggle gap-2">
                                            <div class="row child-cols g-2" data-uc-grid>
                                                <div class="col-auto">
                                                    <div class="post-media panel overflow-hidden max-w-64px min-w-64px">
                                                        <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                                                src="{{ asset('assets/img/blog/blog-default.png') }}"
                                                                data-src="{{ $post->main_image ? asset($post->main_image) : asset('assets/img/blog/blog-default.png') }}"
                                                                alt="{{ $post->title }}"
                                                                data-uc-img="loading: lazy">
                                                        </div>
                                                        <a href="{{ route('frontend.news.show', ['category' => $post->category->slug, 'post' => $post->slug]) }}" class="position-cover"></a>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="post-header panel vstack justify-between gap-1">
                                                        <h3 class="post-title h6 m-0 text-truncate-2">
                                                            <a class="text-none hover:text-primary duration-150"
                                                                href="{{ route('frontend.news.show', ['category' => $post->category->slug, 'post' => $post->slug]) }}">
                                                                {{ $post->title }}
                                                            </a>
                                                        </h3>
                                                        <div class="post-meta panel hstack gap-1 fs-7 text-gray-500">
                                                            <div class="hstack gap-narrow">
                                                                <i class="unicon-favorite"></i>
                                                                <span>{{ $post->likes_count }}</span>
                                                            </div>
                                                            <div>·</div>
                                                            <div class="hstack gap-narrow">
                                                                <i class="unicon-calendar"></i>
                                                                <span>{{ $post->published_at->format('M d, Y') }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="swiper-nav nav-prev position-absolute top-50 start-0 translate-middle btn btn-alt-primary text-black rounded-circle p-0 border shadow-xs w-32px h-32px z-1">
                            <i class="icon-1 unicon-chevron-left"></i>
                        </div>
                        <div class="swiper-nav nav-next position-absolute top-50 start-100 translate-middle btn btn-alt-primary text-black rounded-circle p-0 border shadow-xs w-32px h-32px z-1">
                            <i class="icon-1 unicon-chevron-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Section end -->
@endif
