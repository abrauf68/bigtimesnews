{{-- resources/views/frontend/sections/hot-now.blade.php --}}
<!-- Section start -->
<div class="section panel overflow-hidden swiper-parent mb-5" id="hot-now-section">
    <div class="section-outer panel dark:text-white">
        <div class="container max-w-xl">
            <div class="section-inner panel vstack gap-2">
                <div class="block-layout carousel-layout vstack gap-2 lg:gap-3 panel">
                    <div class="block-header panel pt-1 border-top">
                        <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">Hot now</h2>
                    </div>
                    <div class="block-content panel position-relative">
                        <!-- Swiper container without data-uc-swiper -->
                        <div class="swiper-container" id="hot-now-swiper-container">
                            <div class="swiper-wrapper" id="hot-now-wrapper">
                                <!-- Skeleton slides -->
                                <div class="swiper-slide">
                                    <div class="skeleton-card">
                                        <div class="skeleton-image ratio ratio-3x2"></div>
                                        <div class="skeleton-title"></div>
                                        <div class="skeleton-title short"></div>
                                        <div class="skeleton-meta"></div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="skeleton-card">
                                        <div class="skeleton-image ratio ratio-3x2"></div>
                                        <div class="skeleton-title"></div>
                                        <div class="skeleton-title short"></div>
                                        <div class="skeleton-meta"></div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="skeleton-card">
                                        <div class="skeleton-image ratio ratio-3x2"></div>
                                        <div class="skeleton-title"></div>
                                        <div class="skeleton-title short"></div>
                                        <div class="skeleton-meta"></div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="skeleton-card">
                                        <div class="skeleton-image ratio ratio-3x2"></div>
                                        <div class="skeleton-title"></div>
                                        <div class="skeleton-title short"></div>
                                        <div class="skeleton-meta"></div>
                                    </div>
                                </div>
                                <div class="swiper-slide">
                                    <div class="skeleton-card">
                                        <div class="skeleton-image ratio ratio-3x2"></div>
                                        <div class="skeleton-title"></div>
                                        <div class="skeleton-title short"></div>
                                        <div class="skeleton-meta"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Navigation Buttons -->
                        <div class="swiper-nav nav-prev position-absolute top-50 start-0 translate-middle-y btn btn-alt-primary text-black rounded-circle p-0 border shadow-xs w-32px lg:w-40px h-32px lg:h-40px z-1" style="left: -10px;">
                            <i class="icon-1 unicon-chevron-left"></i>
                        </div>
                        <div class="swiper-nav nav-next position-absolute top-50 end-0 translate-middle-y btn btn-alt-primary text-black rounded-circle p-0 border shadow-xs w-32px lg:w-40px h-32px lg:h-40px z-1" style="right: -10px;">
                            <i class="icon-1 unicon-chevron-right"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .skeleton-card {
        background: #f5f5f5;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .skeleton-image {
        background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
        background-size: 200% 100%;
        animation: skeleton-loading 1.5s infinite;
    }
    
    .skeleton-title {
        height: 18px;
        background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
        background-size: 200% 100%;
        animation: skeleton-loading 1.5s infinite;
        margin: 12px 12px 8px 12px;
        border-radius: 4px;
    }
    
    .skeleton-title.short {
        width: 70%;
        margin-top: 0;
    }
    
    .skeleton-meta {
        height: 12px;
        width: 50%;
        background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
        background-size: 200% 100%;
        animation: skeleton-loading 1.5s infinite;
        margin: 0 12px 12px 12px;
        border-radius: 4px;
    }
    
    @keyframes skeleton-loading {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
    
    .swiper-container {
        overflow: hidden;
        width: 100%;
    }
    
    .swiper-wrapper {
        display: flex;
    }
    
    .swiper-slide {
        flex-shrink: 0;
        width: calc(20% - 20px);
        margin-right: 20px;
    }
    
    @media (max-width: 1200px) {
        .swiper-slide { width: calc(33.333% - 20px); }
    }
    
    @media (max-width: 768px) {
        .swiper-slide { width: calc(50% - 20px); }
    }
</style>

<script>
let hotNowSwiper = null;

document.addEventListener('DOMContentLoaded', function() {
    // Initialize skeleton swiper
    initHotNowSwiper();
    
    // Load real data after 500ms
    setTimeout(() => {
        loadHotNowPosts();
    }, 500);
});

function initHotNowSwiper() {
    const container = document.getElementById('hot-now-swiper-container');
    if (!container) return;
    
    // Destroy existing swiper
    if (hotNowSwiper) {
        hotNowSwiper.destroy(true, true);
        hotNowSwiper = null;
    }
    
    // Get responsive settings
    const getSlidesPerView = () => {
        const width = window.innerWidth;
        if (width >= 1200) return 5;
        if (width >= 768) return 3;
        return 2;
    };
    
    // Initialize with Swiper (if available) or use simple slider
    if (typeof Swiper !== 'undefined') {
        hotNowSwiper = new Swiper(container, {
            slidesPerView: getSlidesPerView(),
            spaceBetween: 24,
            navigation: {
                nextEl: '.nav-next',
                prevEl: '.nav-prev',
            },
            breakpoints: {
                768: { slidesPerView: 3, spaceBetween: 24 },
                1200: { slidesPerView: 5, spaceBetween: 24 }
            }
        });
    } else if (window.UIkit && window.UIkit.swiper) {
        // Use UIkit swiper
        UIkit.swiper(container, {
            items: getSlidesPerView(),
            gap: 24,
            next: '.nav-next',
            prev: '.nav-prev'
        });
        hotNowSwiper = container;
    }
}

async function loadHotNowPosts() {
    const wrapper = document.getElementById('hot-now-wrapper');
    if (!wrapper) return;
    
    try {
        const response = await fetch('/api/hot-now', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        
        const data = await response.json();
        
        if (data.html) {
            // Extract only the swiper-wrapper content
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = data.html;
            const newWrapper = tempDiv.querySelector('.swiper-wrapper');
            
            if (newWrapper) {
                // Replace wrapper content
                wrapper.innerHTML = newWrapper.innerHTML;
            } else {
                wrapper.innerHTML = data.html;
            }
            
            // Reinitialize swiper with new content
            setTimeout(() => {
                initHotNowSwiper();
                
                // Initialize lazy loading
                if (window.UIkit) {
                    window.UIkit.lazyLoad();
                    window.UIkit.update(wrapper);
                }
            }, 100);
        }
    } catch (error) {
        console.error('Failed to load hot now posts:', error);
        wrapper.innerHTML = `
            <div class="swiper-slide">
                <div class="text-center py-5">
                    <i class="unicon-alert-circle fs-1 text-danger"></i>
                    <p class="mt-3 text-danger">Failed to load posts</p>
                    <button class="btn btn-sm btn-primary mt-2" onclick="location.reload()">Retry</button>
                </div>
            </div>
        `;
    }
}

// Handle window resize
let resizeTimer;
window.addEventListener('resize', function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(() => {
        initHotNowSwiper();
    }, 250);
});
</script>