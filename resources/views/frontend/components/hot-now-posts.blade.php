{{-- resources/views/frontend/components/hot-now-posts.blade.php --}}
@props(['posts'])

@if($posts->count() > 0)
    @foreach($posts as $post)
    <div class="swiper-slide">
        <div>
            <article class="post type-post panel uc-transition-toggle vstack gap-2">
                <div class="post-media panel overflow-hidden">
                    <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                            src="{{ asset('assets/img/blog/blog-default.png') }}"
                            data-src="{{ $post->main_image ? asset($post->main_image) : asset('assets/img/blog/blog-default.png') }}"
                            alt="{{ $post->title }}"
                            data-uc-img="loading: lazy"
                            loading="lazy">
                    </div>
                    <a href="{{ route('frontend.post.details', $post->slug) }}" class="position-cover"></a>
                </div>
                <div class="post-header panel vstack gap-1">
                    <h3 class="post-title h6 m-0 text-truncate-2">
                        <a class="text-none hover:text-primary duration-150"
                            href="{{ route('frontend.post.details', $post->slug) }}">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <div class="post-meta panel hstack justify-start gap-1 fs-7 ft-tertiary fw-medium text-gray-900 dark:text-white text-opacity-60">
                        <div>
                            <div class="post-date hstack gap-narrow">
                                <i class="unicon-calendar"></i>
                                <span>{{ $post->published_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div>·</div>
                        <div>
                            <div class="hstack gap-narrow">
                                <i class="unicon-heart"></i>
                                <span>{{ $post->likes_count ?? 0 }}</span>
                            </div>
                        </div>
                        <div>·</div>
                        <div>
                            <a href="{{ route('frontend.post.details', $post->slug) }}#comments"
                                class="post-comments text-none hstack gap-narrow">
                                <i class="icon-narrow unicon-chat"></i>
                                <span>{{ $post->comments_count ?? 0 }}</span>
                            </a>
                        </div>
                    </div>
                </div>
            </article>
        </div>
    </div>
    @endforeach
@else
    <div class="swiper-slide">
        <div class="text-center py-5">
            <i class="unicon-inbox fs-1 text-gray-400"></i>
            <p class="mt-3 text-gray-500">No hot posts available</p>
        </div>
    </div>
@endif