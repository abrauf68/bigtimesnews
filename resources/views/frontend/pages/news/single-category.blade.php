@extends('frontend.layouts.master')

@section('title', $category->title)
@section('meta_title', $category->meta_title)
@section('meta_description', $category->meta_description)
@section('meta_keywords', $category->meta_keywords)
@section('author', $category->author)

@section('css')
<style>
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}
.skeleton-loading {
    animation: pulse 1.5s ease-in-out infinite;
}
/* Sticky Sidebar Styles */
.sidebar-sticky {
    position: sticky;
    top: 90px;
    align-self: start;
}
@media (max-width: 991px) {
    .sidebar-sticky {
        position: relative;
        top: 0;
    }
}
/* Ensure parent has proper height */
.row.child-cols-12.lg\:child-cols > div {
    align-items: start;
}

/* Sticky sidebar utility */
.sticky-top-custom {
    position: sticky;
    top: 20px;
    z-index: 1;
}

/* For smooth sticky behavior */
@media (min-width: 992px) {
    .sticky-sidebar {
        position: sticky;
        top: 100px;
        height: fit-content;
    }
}
</style>
@endsection

@section('breadcrumb-items')
@endsection

@section('content')
    @php
        $featured = $posts->first();
        $sidePosts = $posts->skip(1);
    @endphp

    <!-- Section 1: Featured Posts (Static - loads with page) -->
    <div id="tv-posts" class="tv-posts section panel overflow-hidden bg-gray-800 text-white uc-dark">
        <div class="section-outer panel py-4 sm:py-5">
            <div class="container max-w-xl">
                <div class="section-inner panel vstack gap-3 xl:gap-4">
                    <div class="section-header panel vstack items-center justify-center text-center gap-1">
                        <h2 class="h6 lg:h5 m-0 text-white hstack gap-1">
                            <span class="panel d-inline-block bg-primary w-8px h-8px translate-y-px"></span>
                            <span>{{ $category->name }}</span>
                        </h2>
                    </div>
                    <div class="section-content">
                        <div class="block-layout grid-overlay-layout">
                            <div class="block-content">
                                <div class="row child-cols-12 md:child-cols-6 g-1 col-match">
                                    <div>
                                        <div>
                                            @if($featured)
                                                <article class="post type-post panel vstack gap-2 lg:gap-3 h-100">
                                                    <div class="post-media panel uc-transition-toggle overflow-hidden h-100">
                                                        <div class="featured-image bg-gray-25 dark:bg-gray-800 h-100 d-none md:d-block">
                                                            <canvas class="h-100 w-100"></canvas>
                                                            <img class="uc-transition-scale-up uc-transition-opaque media-cover image"
                                                                src="{{ $featured->main_image ? asset($featured->main_image) : asset('assets/img/blog/blog-default.png') }}"
                                                                alt="{{ $featured->title }}">
                                                        </div>
                                                        <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-16x9 d-block md:d-none">
                                                            <img class="uc-transition-scale-up uc-transition-opaque media-cover image"
                                                                src="{{ $featured->main_image ? asset($featured->main_image) : asset('assets/img/blog/blog-default.png') }}"
                                                                alt="{{ $featured->title }}">
                                                        </div>
                                                    </div>
                                                    <div class="position-cover bg-gradient-to-t from-black to-transparent opacity-90"></div>
                                                    <div class="post-header panel vstack justify-end items-start gap-1 sm:gap-2 p-2 sm:p-4 position-cover text-white">
                                                        <h3 class="post-title h5 sm:h4 xl:h3 m-0 max-w-600px text-white text-truncate-2">
                                                            <a class="text-none text-white" href="{{ route('frontend.news.show', [$featured->category->slug, $featured->slug]) }}">{{ $featured->title }}</a>
                                                        </h3>
                                                        <div class="post-meta panel hstack justify-start gap-1 fs-7 fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1">
                                                            <div>
                                                                <div class="post-category hstack gap-narrow fw-semibold">
                                                                    <a class="text-none hover:text-primary dark:text-primary duration-150" href="{{ route('frontend.news.category', $featured->category->slug) }}">{{ $featured->category->name }}</a>
                                                                </div>
                                                            </div>
                                                            <div class="sep d-none md:d-block">❘</div>
                                                            <div class="d-none md:d-block">
                                                                <div class="post-date hstack gap-narrow">
                                                                    <span>{{ $featured->created_at->format('M d, Y') }}</span>
                                                                </div>
                                                            </div>
                                                            <div class="cstack w-16px h-16px ms-narrow d-none md:d-inline-flex position-absolute top-0 end-0">
                                                                <a href="#" class="uc-bookmark-toggle w-16px h-16px text-none" data-uc-tooltip="Add to bookmark">
                                                                    <i class="icon-narrow unicon-bookmark-add"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <a href="{{ route('frontend.news.show', [$featured->category->slug, $featured->slug]) }}" class="position-cover"></a>
                                                </article>
                                            @endif
                                        </div>
                                    </div>
                                    <div>
                                        <div class="panel">
                                            <div class="row child-cols-6 g-1">
                                                @foreach ($sidePosts as $post)
                                                    <div>
                                                        <article class="post type-post panel vstack gap-2 lg:gap-3">
                                                            <div class="post-media panel uc-transition-toggle overflow-hidden">
                                                                <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1 sm:ratio-4x3">
                                                                    <img class="media-cover image"
                                                                        src="{{ $post->main_image ? asset($post->main_image) : asset('assets/img/blog/blog-default.png') }}"
                                                                        alt="{{ $post->title }}">
                                                                </div>
                                                            </div>
                                                            <div class="position-cover bg-gradient-to-t from-black to-transparent opacity-90"></div>
                                                            <div class="post-header panel vstack justify-end items-start gap-1 p-2 position-cover text-white">
                                                                <h3 class="post-title h6 sm:h5 lg:h6 xl:h5 m-0 max-w-600px text-white text-truncate-2">
                                                                    <a class="text-none text-white" href="{{ route('frontend.news.show', [$post->category->slug, $post->slug]) }}">{{ $post->title }}</a>
                                                                </h3>
                                                                <div class="post-meta panel hstack justify-start gap-1 fs-7 fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1">
                                                                    <div>
                                                                        <div class="post-category hstack gap-narrow fw-semibold">
                                                                            <a class="text-none hover:text-primary dark:text-primary duration-150" href="{{ route('frontend.news.category', $post->category->slug) }}">{{ $post->category->name }}</a>
                                                                        </div>
                                                                    </div>
                                                                    <div class="sep d-none md:d-block">❘</div>
                                                                    <div class="d-none md:d-block">
                                                                        <div class="post-date hstack gap-narrow">
                                                                            <span>{{ $post->created_at->format('M d, Y') }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <a href="{{ route('frontend.news.show', [$post->category->slug, $post->slug]) }}" class="position-cover"></a>
                                                        </article>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- Section 2: Dynamic Posts with Infinite Scroll (AJAX loaded) -->
        <div id="trending-posts" class="trending-posts section panel overflow-hidden">
            <div class="section-outer panel py-4 sm:py-5">
                <div class="container max-w-xl">
                    <div class="section-inner">
                        <div class="row child-cols-12 lg:child-cols col-match g-3 xl:g-4" data-uc-grid style="align-items: start;">
                            <!-- Left Sidebar: Most Watched (Sticky) -->
                           <div class="lg:col-4">
                                <div style="position: sticky; top: 90px; align-self: start;">
                                    <div id="most-watched-container" class="block-layout grid-layout vstack gap-2 lg:gap-3 panel overflow-hidden p-3 bg-gray-25 dark:bg-gray-800">
                                        <div class="block-header panel">
                                            <h2 class="h6 lg:h5 m-0 text-inherit dark:text-white hstack gap-1">
                                                <span class="panel d-inline-block bg-primary w-8px h-8px translate-y-px"></span>
                                                <a class="text-none hover:text-primary duration-150" href="#">Most watched</a>
                                            </h2>
                                        </div>
                                        <div class="block-content">
                                            <div id="most-watched-loader" class="vstack gap-3">
                                                @for($i = 0; $i < 5; $i++)
                                                <div class="skeleton-loading" style="height: 70px; background: #e0e0e0; border-radius: 8px;"></div>
                                                @endfor
                                            </div>
                                            <div id="most-watched-posts" style="display: none;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Content: Related Posts with Infinite Scroll -->
                            <div class="lg:col-8">
                                <div class="block-layout grid-layout vstack gap-2 xl:gap-3 panel overflow-hidden">
                                    <div class="block-header panel hstack justify-between px-2 py-1 bg-gray-800 text-white uc-dark">
                                        <h2 class="h6 lg:h5 m-0 text-inherit dark:text-white hstack gap-1">
                                            <span class="panel d-inline-block bg-primary w-8px h-8px translate-y-px"></span>
                                            <a class="text-none hover:text-primary duration-150" href="#">{{ $category->name }}</a>
                                        </h2>
                                        <ul class="nav-x gap-narrow">
                                            <li>
                                                <a href="#" class="w-24px h-24px cstack rounded-circle hover:bg-primary hover:text-dark transition-colors duration-200">
                                                    <i class="icon icon-1 unicon-logo-x-filled"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#" class="w-24px h-24px cstack rounded-circle hover:bg-primary hover:text-dark transition-colors duration-200">
                                                    <i class="icon icon-1 unicon-logo-instagram"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="block-content">
                                        <div id="related-posts-loader" class="row child-cols-6 g-2 gy-3 md:gx-3 md:gy-4">
                                            @for($i = 0; $i < 6; $i++)
                                            <div class="col-6">
                                                <div class="skeleton-loading" style="height: 220px; background: #e0e0e0; border-radius: 12px;"></div>
                                            </div>
                                            @endfor
                                        </div>
                                        <div id="related-posts-container" class="row child-cols-6 g-2 gy-3 md:gx-3 md:gy-4" style="display: none;"></div>

                                        <!-- Infinite Scroll Trigger -->
                                        <div id="infinite-scroll-trigger" class="infinite-trigger text-center py-4" style="display: block;">
                                            <div class="spinner-border text-primary" role="status" style="display: none;">
                                                <span class="visually-hidden">Loading more posts...</span>
                                            </div>
                                            <div class="load-more-btn">
                                                <button class="btn btn-primary btn-sm">Load More</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
@endsection

@section('script')
<script>
// Category Detail Page Dynamic Loading
class CategoryDetailInfiniteScroll {
    constructor(categorySlug) {
        this.categorySlug = categorySlug;
        this.relatedPage = 1;
        this.hasMoreRelated = true;
        this.loadingRelated = false;
        this.init();
    }

    async init() {
        console.log('Initializing for category:', this.categorySlug);
        await this.loadMostWatched();
        await this.loadRelatedPosts(1);
        this.setupInfiniteScroll();
    }

    async loadMostWatched() {
        const loader = document.getElementById('most-watched-loader');
        const container = document.getElementById('most-watched-posts');

        if (!loader || !container) {
            console.error('Most watched elements not found');
            return;
        }

        try {
            console.log('Fetching most watched posts for:', this.categorySlug);
            const response = await fetch(`/api/most-watched-posts?category_slug=${this.categorySlug}`);
            const data = await response.json();

            console.log('Most watched response:', data);

            if (data.success && data.html) {
                container.innerHTML = data.html;
                loader.style.display = 'none';
                container.style.display = 'block';
                this.initLazyLoading(container);
            } else {
                console.error('Failed to load most watched:', data.message);
                loader.innerHTML = '<div class="text-danger">Failed to load most watched posts</div>';
            }
        } catch (error) {
            console.error('Error loading most watched:', error);
            loader.innerHTML = '<div class="text-danger">Error loading most watched posts</div>';
        }
    }

    async loadRelatedPosts(page) {
        if (this.loadingRelated) {
            console.log('Already loading, skipping');
            return;
        }

        if (!this.hasMoreRelated && page > 1) {
            console.log('No more posts to load');
            this.hideTrigger();
            return;
        }

        this.loadingRelated = true;
        const loader = document.getElementById('related-posts-loader');
        const container = document.getElementById('related-posts-container');
        const trigger = document.getElementById('infinite-scroll-trigger');
        const spinner = trigger ? trigger.querySelector('.spinner-border') : null;
        const loadMoreBtn = trigger ? trigger.querySelector('.load-more-btn') : null;

        if (page === 1) {
            if (loader) loader.style.display = 'flex';
            if (container) container.style.display = 'none';
        } else {
            if (spinner) spinner.style.display = 'inline-block';
            if (loadMoreBtn) loadMoreBtn.style.display = 'none';
        }

        try {
            console.log(`Fetching related posts page ${page} for category:`, this.categorySlug);
            const response = await fetch(`/api/category/${this.categorySlug}/related-posts?page=${page}`);
            const data = await response.json();

            console.log('Related posts response:', data);

            if (data.success) {
                if (page === 1) {
                    if (container) {
                        container.innerHTML = data.html;
                        if (loader) loader.style.display = 'none';
                        container.style.display = 'flex';
                    }
                } else {
                    if (container) {
                        container.insertAdjacentHTML('beforeend', data.html);
                    }
                }

                this.hasMoreRelated = data.hasMorePages;
                this.relatedPage = data.nextPage;

                console.log('Has more pages:', this.hasMoreRelated, 'Next page:', this.relatedPage);

                this.initLazyLoading(container);

                if (window.UIkit) window.UIkit.update(container);

                // Update trigger visibility
                if (!this.hasMoreRelated) {
                    this.hideTrigger();
                } else {
                    this.showTrigger();
                }
            } else {
                console.error('Failed to load related posts:', data.message);
                if (page === 1 && loader) {
                    loader.innerHTML = '<div class="text-danger text-center py-5">' + (data.message || 'Failed to load posts') + '</div>';
                }
            }
        } catch (error) {
            console.error('Error loading related posts:', error);
            if (page === 1 && loader) {
                loader.innerHTML = '<div class="text-danger text-center py-5">Error loading posts. Please refresh the page.</div>';
            }
        } finally {
            this.loadingRelated = false;
            const trigger = document.getElementById('infinite-scroll-trigger');
            const spinner = trigger ? trigger.querySelector('.spinner-border') : null;
            const loadMoreBtn = trigger ? trigger.querySelector('.load-more-btn') : null;
            if (spinner) spinner.style.display = 'none';
            if (loadMoreBtn && this.hasMoreRelated) loadMoreBtn.style.display = 'block';
        }
    }

    hideTrigger() {
        const trigger = document.getElementById('infinite-scroll-trigger');
        if (trigger) {
            trigger.style.display = 'none';
        }
    }

    showTrigger() {
        const trigger = document.getElementById('infinite-scroll-trigger');
        if (trigger) {
            trigger.style.display = 'block';
            const loadMoreBtn = trigger.querySelector('.load-more-btn');
            if (loadMoreBtn) loadMoreBtn.style.display = 'block';
        }
    }

    setupInfiniteScroll() {
        const loadMoreBtn = document.querySelector('#infinite-scroll-trigger .load-more-btn button');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', () => {
                if (!this.loadingRelated && this.hasMoreRelated) {
                    console.log('Load more button clicked, loading page:', this.relatedPage);
                    this.loadRelatedPosts(this.relatedPage);
                }
            });
        }

        // Also setup scroll-based infinite scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !this.loadingRelated && this.hasMoreRelated) {
                    console.log('Triggering load for page:', this.relatedPage);
                    this.loadRelatedPosts(this.relatedPage);
                }
            });
        }, { threshold: 0.1, rootMargin: '100px' });

        const trigger = document.getElementById('infinite-scroll-trigger');
        if (trigger) {
            observer.observe(trigger);
            console.log('Infinite scroll observer set up');
        }
    }

    initLazyLoading(container) {
        if (!container) return;
        const images = container.querySelectorAll('img[data-src]');
        images.forEach(img => {
            if (img.dataset.src) {
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
            }
        });
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    const categorySlug = '{{ $category->slug }}';
    console.log('Category slug:', categorySlug);
    if (categorySlug) {
        window.categoryScroll = new CategoryDetailInfiniteScroll(categorySlug);
    } else {
        console.error('No category slug found');
    }
});
</script>
@endsection
