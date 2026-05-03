@if(count($posts) > 0)
    @foreach($posts as $post)
    <div class="col-6">
        <article class="post type-post panel vstack gap-1 lg:gap-2">
            <div class="post-media panel uc-transition-toggle overflow-hidden">
                <div class="featured-image uc-transition-scale-up uc-transition-opaque bg-gray-25 dark:bg-gray-800 ratio ratio-16x9">
                    <img class="media-cover image"
                         src="{{ asset('assets/img/blog/blog-default.png') }}"
                         data-src="{{ $post->main_image ? asset($post->main_image) : asset('assets/img/blog/blog-default.png') }}"
                         alt="{{ $post->title }}"
                         data-uc-img="loading: lazy">
                </div>
                <a href="{{ route('frontend.news.show', [$post->category->slug, $post->slug]) }}" class="position-cover"></a>
            </div>
            <div class="post-header panel vstack gap-1">
                <div class="post-meta panel hstack justify-start gap-1 fs-7 fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1">
                    <div>
                        <div class="post-category hstack gap-narrow fw-semibold">
                            <a class="text-none hover:text-primary dark:text-primary duration-150" href="{{ route('frontend.news.show', [$post->category->slug, $post->slug]) }}">
                                {{ $post->category->name ?? 'Uncategorized' }}
                            </a>
                        </div>
                    </div>
                    <div class="sep d-none md:d-block">❘</div>
                    <div class="d-none md:d-block">
                        <div class="post-date hstack gap-narrow">
                            <span>{{ $post->published_at ? $post->published_at->format('M d, Y') : '' }}</span>
                        </div>
                    </div>
                    <div class="cstack w-16px h-16px ms-narrow d-none md:d-inline-flex position-absolute top-0 end-0">
                        <a href="{{ route('frontend.news.show', [$post->category->slug, $post->slug]) }}" class="uc-bookmark-toggle w-16px h-16px text-none" data-uc-tooltip="Add to bookmark">
                            <i class="icon-narrow unicon-bookmark-add"></i>
                        </a>
                    </div>
                </div>
                <h3 class="post-title h6 lg:h5 fw-semibold m-0 text-truncate-2 mb-1">
                    <a class="text-none hover:text-primary duration-150" href="{{ route('frontend.news.show', [$post->category->slug, $post->slug]) }}">
                        {{ $post->title }}
                    </a>
                </h3>
            </div>
        </article>
    </div>
    @endforeach
@else
    <div class="col-12 text-center py-5">
        <p>No posts found in this category.</p>
    </div>
@endif
