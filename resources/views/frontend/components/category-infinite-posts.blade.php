@if(isset($posts) && count($posts) > 0)
    @php
        $firstPost = $posts->shift();
    @endphp

    <div class="panel row child-cols-12 md:child-cols gy-4 md:gx-3 xl:gx-4">
        <div class="col-12 md:col-6 lg:col-7">
            <div>
                <article class="post type-post panel vstack gap-1 lg:gap-2">
                    <div class="post-media panel uc-transition-toggle overflow-hidden">
                        <div class="featured-image bg-gray-25 dark:bg-gray-800 overflow-hidden ratio ratio-16x9">
                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                 src="{{ asset('assets/images/common/img-fallback.png') }}"
                                 data-src="{{ $firstPost->main_image ? asset($firstPost->main_image) : asset('assets/img/blog/blog-default.png') }}"
                                 alt="{{ $firstPost->title }}"
                                 data-uc-img="loading: lazy">
                        </div>
                        <a href="{{ route('post.detail', $firstPost->slug) }}" class="position-cover"></a>
                    </div>
                    <div class="post-header panel vstack gap-1">
                        <div class="post-meta panel hstack justify-start gap-1 fs-7 fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1">
                            <div>
                                <div class="post-category hstack gap-narrow fw-medium">
                                    <a class="text-none text-primary dark:text-white" href="{{ route('category.detail', $firstPost->category->slug ?? '#') }}">
                                        {{ $firstPost->category->name ?? 'Uncategorized' }}
                                    </a>
                                </div>
                            </div>
                            <div class="sep d-none md:d-block">❘</div>
                            <div class="d-none md:d-block">
                                <div class="post-date hstack gap-narrow">
                                    <span>{{ $firstPost->published_at ? $firstPost->published_at->diffForHumans() : 'Recently' }}</span>
                                </div>
                            </div>
                        </div>
                        <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                            <a class="text-none hover:text-primary duration-150" href="{{ route('post.detail', $firstPost->slug) }}">{{ $firstPost->title }}</a>
                        </h3>
                        <p class="fs-6 opacity-60 text-truncate-2 my-1">{{ Str::limit(strip_tags($firstPost->content), 120) }}</p>
                        <div class="post-meta panel hstack justify-between fs-7 fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                            <div class="meta">
                                <div class="hstack gap-2">
                                    <div>
                                        <div class="post-author hstack gap-1">
                                            @if($firstPost->author && $firstPost->author->avatar)
                                            <a href="{{ route('author.posts', $firstPost->author->id) }}" data-uc-tooltip="{{ $firstPost->author->name }}">
                                                <img src="{{ asset($firstPost->author->avatar) }}" alt="{{ $firstPost->author->name }}" class="w-24px h-24px rounded-circle">
                                            </a>
                                            @endif
                                            <a href="{{ route('author.posts', $firstPost->author->id ?? '#') }}" class="text-black dark:text-white text-none fw-bold">
                                                {{ $firstPost->author->name ?? 'Unknown Author' }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
        </div>
        <div>
            <div class="row child-cols-12 g-4 sep-x">
                @foreach($posts as $post)
                <div>
                    <article class="post type-post panel">
                        <div class="row child-cols g-2" data-uc-grid>
                            <div class="col-auto">
                                <div class="post-media panel uc-transition-toggle overflow-hidden max-w-150px min-w-100px lg:min-w-150px">
                                    <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-16x9">
                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                                             src="{{ asset('assets/images/common/img-fallback.png') }}"
                                             data-src="{{ $post->main_image ? asset($post->main_image) : asset('assets/img/blog/blog-default.png') }}"
                                             alt="{{ $post->title }}"
                                             data-uc-img="loading: lazy">
                                    </div>
                                    <a href="{{ route('post.detail', $post->slug) }}" class="position-cover"></a>
                                </div>
                            </div>
                            <div>
                                <div class="post-header panel vstack justify-between gap-1">
                                    <div class="post-meta panel hstack justify-start gap-1 fs-7 fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1">
                                        <div>
                                            <div class="post-category hstack gap-narrow fw-medium">
                                                <a class="text-none text-primary dark:text-white" href="{{ route('category.detail', $post->category->slug ?? '#') }}">
                                                    {{ $post->category->name ?? 'Uncategorized' }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="sep d-none md:d-block">❘</div>
                                        <div class="d-none md:d-block">
                                            <div class="post-date hstack gap-narrow">
                                                <span>{{ $post->published_at ? $post->published_at->diffForHumans() : 'Recently' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="post-title h6 lg:h5 m-0 text-truncate-2">
                                        <a class="text-none hover:text-primary duration-150" href="{{ route('post.detail', $post->slug) }}">{{ $post->title }}</a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@else
    <div class="text-center py-5">
        <p>No posts found in this category.</p>
    </div>
@endif
