<!-- Section start -->
<div id="latest_news" class="latest-news section panel">
    <div class="section-outer panel py-4 lg:py-6">
        <div class="container max-w-xl">
            <div class="section-inner">
                <div class="content-wrap row child-cols-12 g-4 lg:g-6" data-uc-grid>
                    <div class="md:col-9">
                        <div class="main-wrap panel vstack gap-3 lg:gap-6">
                            <div class="block-layout grid-layout vstack gap-2 panel overflow-hidden">
                                <div class="block-header panel pt-1 border-top">
                                    <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">
                                        Latest
                                    </h2>
                                </div>
                                <div class="block-content">
                                    <div id="latest-posts-container" class="row child-cols-12 g-2 lg:g-4 sep-x">
                                        <!-- Skeleton will be shown here -->
                                        <div class="latest-posts-skeleton">
                                            @for($i = 1; $i <= 6; $i++)
                                            <div class="skeleton-post-item">
                                                <div class="row g-3">
                                                    <div class="col-auto">
                                                        <div class="skeleton-image" style="width: 250px; height: 167px; background: #e0e0e0; border-radius: 8px;"></div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="skeleton-title" style="width: 30%; height: 20px; background: #e0e0e0; border-radius: 4px; margin-bottom: 12px;"></div>
                                                        <div class="skeleton-title" style="width: 80%; height: 24px; background: #e0e0e0; border-radius: 4px; margin-bottom: 12px;"></div>
                                                        <div class="skeleton-meta" style="width: 50%; height: 16px; background: #e0e0e0; border-radius: 4px; margin-bottom: 12px;"></div>
                                                        <div class="skeleton-text" style="width: 100%; height: 60px; background: #e0e0e0; border-radius: 4px; margin-bottom: 12px;"></div>
                                                        <div class="skeleton-button" style="width: 100px; height: 30px; background: #e0e0e0; border-radius: 4px;"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            @endfor
                                        </div>
                                    </div>
                                    <div id="loading-spinner" class="text-center py-4" style="display: none;">
                                        <div class="spinner-border text-primary" role="status">
                                            <span class="visually-hidden"></span>
                                        </div>
                                        <p class="mt-2">Loading more posts...</p>
                                    </div>
                                    <div id="no-more-posts" class="text-center py-4" style="display: none;">
                                        <p class="text-gray-500">You've reached the end! No more posts to load.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="md:col-3">
                        <!-- Remove data-uc-sticky and use custom CSS -->
                        <div class="sidebar-wrap panel vstack gap-2 pb-2">
                            
                            <!-- Ad Widget -->
                            <div class="widget ad-widget vstack gap-2 text-center p-2 border">
                                <div class="widgt-content">
                                    <a class="cstack max-w-300px mx-auto text-none"
                                        href="https://themeforest.net/user/reacthemes/portfolio" target="_blank"
                                        rel="nofollow">
                                        <img class="d-block dark:d-none"
                                            src="{{ asset('front/images/common/ad-slot-aside.jpg') }}" alt="Ad slot">
                                        <img class="d-none dark:d-block"
                                            src="{{ asset('front/images/common/ad-slot-aside-2.jpg') }}" alt="Ad slot">
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Popular Now Widget -->
                            <div class="widget popular-widget vstack gap-2 p-2 border">
                                <div class="widget-title text-center">
                                    <h5 class="fs-7 ft-tertiary text-uppercase m-0">Popular now</h5>
                                </div>
                                <div class="widget-content" id="popular-posts-container">
                                    <div class="popular-posts-skeleton">
                                        @for($i = 1; $i <= 4; $i++)
                                        <div class="skeleton-popular-item" style="margin-bottom: 15px;">
                                            <div class="hstack gap-3">
                                                <div class="skeleton-number" style="width: 30px; height: 40px; background: #e0e0e0; border-radius: 4px;"></div>
                                                <div style="flex: 1;">
                                                    <div class="skeleton-title" style="width: 90%; height: 18px; background: #e0e0e0; border-radius: 4px; margin-bottom: 8px;"></div>
                                                    <div class="skeleton-meta" style="width: 60%; height: 14px; background: #e0e0e0; border-radius: 4px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Social Widget -->
                            <div class="widget social-widget vstack gap-2 text-center p-2 border">
                                <div class="widgt-title">
                                    <h4 class="fs-7 ft-tertiary text-uppercase m-0">Follow @News5</h4>
                                </div>
                                <div class="widgt-content">
                                    <form class="vstack gap-1">
                                        <input
                                            class="form-control form-control-sm fs-6 fw-medium h-40px w-full bg-white dark:bg-gray-800 dark:border-white dark:border-opacity-15"
                                            type="email" placeholder="Your email" required>
                                        <button class="btn btn-sm btn-primary" type="submit">Sign up</button>
                                    </form>
                                    <ul class="nav-x justify-center gap-1 mt-3">
                                        <li>
                                            <a href="#fb" class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150">
                                                <i class="icon icon-1 unicon-logo-facebook"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#x" class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150">
                                                <i class="icon icon-1 unicon-logo-x-filled"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#in" class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150">
                                                <i class="icon icon-1 unicon-logo-instagram"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#yt" class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150">
                                                <i class="icon icon-1 unicon-logo-youtube"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@keyframes skeleton-shimmer {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}
@keyframes skeleton-fade {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}
.skeleton-post-item {
    margin-bottom: 30px;
    padding-bottom: 30px;
    border-bottom: 1px solid #eee;
    animation: skeleton-fade 1.2s ease-in-out infinite;
}
.skeleton-image,
.skeleton-title,
.skeleton-meta,
.skeleton-text,
.skeleton-button,
.skeleton-number {
    background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
    background-size: 200% 100%;
    animation: skeleton-shimmer 1.5s infinite;
}
.skeleton-popular-item {
    animation: skeleton-fade 1.2s ease-in-out infinite;
}
.latest-post-item {
    margin-bottom: 30px;
    padding-bottom: 30px;
    border-bottom: 1px solid #e5e5e5;
}
.latest-post-item:last-child {
    border-bottom: none;
}
.spinner-border {
    display: inline-block;
    width: 2rem;
    height: 2rem;
    border: 0.25em solid currentColor;
    border-right-color: transparent;
    border-radius: 50%;
    animation: spinner-border 0.75s linear infinite;
}
@keyframes spinner-border {
    to { transform: rotate(360deg); }
}
.text-truncate-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

<script>
let currentPage = 1;
let isLoading = false;
let hasMorePages = true;
let sentinelObserver = null;

// Load initial posts
document.addEventListener('DOMContentLoaded', function() {
    loadLatestPosts();
    loadPopularPosts();
    setupInfiniteScroll();
});

// Load latest posts
async function loadLatestPosts() {
    if (isLoading || !hasMorePages) return;
    
    isLoading = true;
    const container = document.getElementById('latest-posts-container');
    const spinner = document.getElementById('loading-spinner');
    
    // Show spinner on subsequent pages
    if (currentPage > 1) {
        spinner.style.display = 'block';
    }
    
    try {
        const response = await fetch(`/api/latest-posts?page=${currentPage}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        
        const data = await response.json();
        
        if (data.html) {
            if (currentPage === 1) {
                container.innerHTML = data.html;
            } else {
                container.insertAdjacentHTML('beforeend', data.html);
            }
            hasMorePages = data.hasMorePages;
        }
        
        if (!hasMorePages) {
            document.getElementById('no-more-posts').style.display = 'block';
            // Disconnect observer when no more posts
            if (sentinelObserver) {
                sentinelObserver.disconnect();
            }
        }
        
        // Reinitialize UIkit components
        if (window.UIkit) {
            window.UIkit.update(container);
            window.UIkit.lazyLoad();
        }
        
    } catch (error) {
        console.error('Failed to load posts:', error);
        if (currentPage === 1) {
            container.innerHTML = '<div class="text-center py-5 text-danger">Failed to load posts. <button onclick="location.reload()" class="btn btn-sm btn-primary">Retry</button></div>';
        }
    } finally {
        isLoading = false;
        spinner.style.display = 'none';
        
        // Re-observe sentinel
        if (hasMorePages) {
            setTimeout(setupInfiniteScroll, 100);
        }
    }
}

// Setup infinite scroll using Intersection Observer on sentinel element
function setupInfiniteScroll() {
    // Remove existing sentinel if any
    const existingSentinel = document.getElementById('scroll-sentinel');
    if (existingSentinel) {
        existingSentinel.remove();
    }
    
    // Create sentinel element
    const container = document.getElementById('latest-posts-container');
    if (!container) return;
    
    const sentinel = document.createElement('div');
    sentinel.id = 'scroll-sentinel';
    sentinel.style.height = '10px';
    sentinel.style.width = '100%';
    sentinel.style.visibility = 'hidden';
    container.appendChild(sentinel);
    
    // Disconnect old observer
    if (sentinelObserver) {
        sentinelObserver.disconnect();
    }
    
    // Create new observer
    sentinelObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && hasMorePages && !isLoading) {
                currentPage++;
                loadLatestPosts();
            }
        });
    }, {
        rootMargin: '0px 0px 200px 0px', // Trigger 200px before reaching the element
        threshold: 0.1
    });
    
    sentinelObserver.observe(sentinel);
}

// Load popular posts
async function loadPopularPosts() {
    const container = document.getElementById('popular-posts-container');
    if (!container) return;
    
    try {
        const response = await fetch('/api/popular-posts', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        
        const data = await response.json();
        
        if (data.html) {
            container.innerHTML = data.html;
        }
    } catch (error) {
        console.error('Failed to load popular posts:', error);
    }
}

// Clean up observer on page unload
window.addEventListener('beforeunload', function() {
    if (sentinelObserver) {
        sentinelObserver.disconnect();
    }
});
</script>