@if(isset($posts) && count($posts) > 0)
    @foreach($posts as $index => $post)
    <div>
        <article class="post type-post panel">
            <div class="row child-cols g-2" data-uc-grid>
                <div>
                    <div class="post-header panel vstack justify-between gap-1">
                        <div class="hstack gap-2">
                            <span class="fw-bold text-primary fs-5">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <div class="post-category">
                                <a class="text-none text-primary small" href="{{ route('frontend.news.category', $post->category->slug) }}">
                                    {{ $post->category->name ?? 'Uncategorized' }}
                                </a>
                            </div>
                        </div>
                        <h3 class="post-title h6 m-0 text-truncate-2">
                            <a class="text-none hover:text-primary duration-150" href="{{ route('frontend.news.show', [$post->category->slug, $post->slug]) }}">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <div class="post-meta fs-7 fw-medium text-gray-900 dark:text-white text-opacity-60">
                            <div class="post-date hstack gap-narrow">
                                <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : '' }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-auto">
                    <div class="post-media panel uc-transition-toggle overflow-hidden max-w-72px min-w-64px lg:min-w-72px">
                        <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                            <img class="media-cover image"
                                 src="{{ asset('assets/img/blog/blog-default.png') }}"
                                 data-src="{{ $post->main_image ? asset($post->main_image) : asset('assets/img/blog/blog-default.png') }}"
                                 alt="{{ $post->title }}"
                                 data-uc-img="loading: lazy">
                        </div>
                        <a href="{{ route('frontend.news.show', [$post->category->slug, $post->slug]) }}" class="position-cover"></a>
                    </div>
                </div>
            </div>
        </article>
    </div>
    @endforeach
@else
    <div class="text-center py-3 text-muted">
        No posts found
    </div>
@endif
