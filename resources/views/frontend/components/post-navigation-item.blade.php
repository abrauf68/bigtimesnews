@if($type == 'prev')
<div class="new-post panel hstack w-100 lg:w-1/2" data-post-url="{{ route('frontend.news.show', [$post->category->slug, $post->slug]) }}">
    <div class="panel hstack justify-center w-100px h-100px">
        <figure class="featured-image m-0 ratio ratio-1x1 rounded uc-transition-toggle overflow-hidden bg-gray-25 dark:bg-gray-800">
            <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                src="{{ asset('assets/img/blog/blog-default.png') }}"
                data-src="{{ $post->main_image ? asset($post->main_image) : asset('assets/img/blog/blog-default.png') }}"
                alt="{{ $post->title }}"
                data-uc-img="loading: lazy">
        </figure>
    </div>
    <div class="panel vstack justify-center px-2 gap-1 w-1/3">
        <span class="fs-7 opacity-60">Prev Article</span>
        <h6 class="h6 lg:h5 m-0 text-truncate-2">{{ $post->title }}</h6>
    </div>
    <a href="{{ route('frontend.news.show', [$post->category->slug, $post->slug]) }}" class="position-cover"></a>
</div>
@else
<div class="new-post panel hstack w-100 lg:w-1/2" data-post-url="{{ route('frontend.news.show', [$post->category->slug, $post->slug]) }}">
    <div class="panel vstack justify-center px-2 gap-1 w-1/3 text-end">
        <span class="fs-7 opacity-60">Next Article</span>
        <h6 class="h6 lg:h5 m-0 text-truncate-2">{{ $post->title }}</h6>
    </div>
    <div class="panel hstack justify-center w-100px h-100px">
        <figure class="featured-image m-0 ratio ratio-1x1 rounded uc-transition-toggle overflow-hidden bg-gray-25 dark:bg-gray-800">
            <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                src="{{ asset('assets/img/blog/blog-default.png') }}"
                data-src="{{ $post->main_image ? asset($post->main_image) : asset('assets/img/blog/blog-default.png') }}"
                alt="{{ $post->title }}"
                data-uc-img="loading: lazy">
        </figure>
    </div>
    <a href="{{ route('frontend.news.show', [$post->category->slug, $post->slug]) }}" class="position-cover"></a>
</div>
@endif
