@props(['posts', 'hasMorePages' => false, 'nextPage' => 2])

@foreach($posts as $post)
<div class="latest-post-item" data-post-id="{{ $post->id }}">
    <article class="post type-post panel uc-transition-toggle">
        <div class="row child-cols g-2 lg:g-3" data-uc-grid>
            <div class="col-auto">
                <div class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                    <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                            src="{{ asset('assets/img/blog/blog-default.png') }}"
                            data-src="{{ $post->main_image ? asset($post->main_image) : asset('assets/img/blog/blog-default.png') }}"
                            alt="{{ $post->title }}"
                            data-uc-img="loading: lazy"
                            loading="lazy">
                    </div>
                    <a href="{{ route('frontend.news.show', ['category' => $post->category->slug, 'post' => $post->slug]) }}" class="position-cover"></a>
                </div>
            </div>
            <div>
                <div class="post-header panel vstack justify-between gap-1">
                    <div class="post-category">
                        <span class="badge bg-primary fs-7 p-1 text-white">{{ $post->category->name ?? 'Uncategorized' }}</span>
                    </div>
                    <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                        <a class="text-none hover:text-primary duration-150"
                            href="{{ route('frontend.news.show', ['category' => $post->category->slug, 'post' => $post->slug]) }}">
                            {{ $post->title }}
                        </a>
                    </h3>
                    <div class="post-meta panel hstack gap-2 fs-7 text-gray-500">
                        <div class="hstack gap-1">
                            <i class="unicon-calendar"></i>
                            <span>{{ $post->published_at->diffForHumans() }}</span>
                        </div>
                        <div>·</div>
                        <div class="hstack gap-1">
                            <i class="unicon-favorite"></i>
                            <span>{{ $post->likes_count ?? 0 }}</span>
                        </div>
                        <div>·</div>
                        <div class="hstack gap-1">
                            <i class="unicon-chat"></i>
                            <span>{{ $post->comments_count ?? 0 }}</span>
                        </div>
                    </div>
                </div>
                <p class="post-excerpt ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-3 my-2">
                    {{ Str::limit(strip_tags($post->content), 150) }}
                </p>
                <div class="post-link">
                    <a href="{{ route('frontend.news.show', ['category' => $post->category->slug, 'post' => $post->slug]) }}"
                        class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                        <span>Read more</span>
                        <i class="icon-1 unicon-chevron-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </article>
</div>
@endforeach
