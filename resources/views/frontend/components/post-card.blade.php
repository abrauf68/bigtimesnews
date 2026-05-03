@props(['post'])

<article class="post type-post panel uc-transition-toggle vstack gap-1">
    <div class="post-media panel overflow-hidden">
        <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-16x9">
            <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                src="{{ asset('assets/img/blog/blog-default.png') }}"
                data-src="{{ $post->main_image ? asset($post->main_image) : asset('assets/img/blog/blog-default.png') }}"
                alt="{{ $post->title }}"
                data-uc-img="loading: lazy">
        </div>
        <a href="{{ route('frontend.news.show', ['category' => $post->category->slug, 'post' => $post->slug]) }}" class="position-cover"></a>
    </div>
    <div class="post-header panel vstack gap-narrow">
        <h3 class="post-title h6 m-0 text-truncate-2">
            <a class="text-none hover:text-primary duration-150"
               href="{{ route('frontend.news.show', ['category' => $post->category->slug, 'post' => $post->slug]) }}">
                {{ $post->title }}
            </a>
        </h3>
        <div class="post-meta panel hstack justify-start gap-1 fs-7 ft-tertiary fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
            <div>
                <div class="post-date hstack gap-narrow">
                    <span>{{ $post->published_at ? $post->published_at->diffForHumans() : 'Draft' }}</span>
                </div>
            </div>
            <div>·</div>
            <div>
                <a href="{{ route('frontend.news.show', ['category' => $post->category->slug, 'post' => $post->slug]) }}#comments"
                   class="post-comments text-none hstack gap-narrow">
                    <i class="icon-narrow unicon-chat"></i>
                    <span>{{ $post->comments_count ?? 0 }}</span>
                </a>
            </div>
        </div>
    </div>
</article>
