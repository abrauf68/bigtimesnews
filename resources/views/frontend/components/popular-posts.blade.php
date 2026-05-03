@props(['posts'])

<div class="row child-cols-12 gx-4 gy-3 sep-x" data-uk-grid>
    @foreach($posts as $index => $post)
    <div>
        <article class="post type-post panel uc-transition-toggle">
            <div class="row child-cols g-2 lg:g-3" data-uk-grid>
                <div>
                    <div class="hstack items-start gap-3">
                        <span class="h3 lg:h2 ft-tertiary fst-italic text-center text-primary m-0 min-w-24px">{{ $index + 1 }}</span>
                        <div class="post-header panel vstack justify-between gap-1">
                            <h3 class="post-title h6 m-0">
                                <a class="text-none hover:text-primary duration-150"
                                    href="{{ route('frontend.news.show', ['category' => $post->category->slug, 'post' => $post->slug]) }}">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            <div class="post-meta panel hstack justify-between fs-7 text-gray-900 dark:text-white text-opacity-60">
                                <div class="meta">
                                    <div class="hstack gap-2">
                                        <div class="post-date hstack gap-narrow">
                                            <span>{{ $post->published_at->diffForHumans() }}</span>
                                        </div>
                                        <div>
                                            <a href="{{ route('frontend.news.show', ['category' => $post->category->slug, 'post' => $post->slug]) }}#comments"
                                                class="post-comments text-none hstack gap-narrow">
                                                <i class="icon-narrow unicon-chat"></i>
                                                <span>{{ $post->comments_count ?? 0 }}</span>
                                            </a>
                                        </div>
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
