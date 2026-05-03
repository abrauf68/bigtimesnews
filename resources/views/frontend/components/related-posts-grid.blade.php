@if($posts->count() > 0)
<div class="row child-cols-6 md:child-cols-3 gx-2 gy-4 sm:gx-3 sm:gy-6">
    @foreach($posts as $relatedPost)
    <div>
        <article class="post type-post panel vstack gap-2">
            <figure class="featured-image m-0 ratio ratio-4x3 rounded uc-transition-toggle overflow-hidden bg-gray-25 dark:bg-gray-800">
                <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                    src="{{ asset('assets/img/blog/blog-default.png') }}"
                    data-src="{{ $relatedPost->main_image ? asset($relatedPost->main_image) : asset('assets/img/blog/blog-default.png') }}"
                    alt="{{ $relatedPost->title }}"
                    data-uc-img="loading: lazy">
                <a href="{{ route('frontend.news.show', [$relatedPost->category->slug, $relatedPost->slug]) }}" class="position-cover"></a>
            </figure>
            <div class="post-header panel vstack gap-1">
                <h5 class="h6 md:h5 m-0">
                    <a class="text-none" href="{{ route('frontend.news.show', [$relatedPost->category->slug, $relatedPost->slug]) }}">
                        {{ $relatedPost->title }}
                    </a>
                </h5>
                <div class="post-date hstack gap-narrow fs-7 opacity-60">
                    <span>{{ $relatedPost->published_at ? $relatedPost->published_at->format('M d, Y') : '' }}</span>
                </div>
            </div>
        </article>
    </div>
    @endforeach
</div>
@else
<div class="text-center py-5">
    <p>No related posts found.</p>
</div>
@endif
