{{-- resources/views/frontend/components/hot-now-skeleton.blade.php --}}
<div class="swiper-wrapper">
    @for($i = 1; $i <= 8; $i++)
    <div class="swiper-slide">
        <div>
            <article class="post type-post vstack gap-2">
                <div class="post-media overflow-hidden">
                    <div class="skeleton-image ratio ratio-3x2" style="background: #e0e0e0;"></div>
                </div>
                <div class="post-header vstack gap-1">
                    <div class="skeleton-title" style="height: 18px; width: 90%; background: #e0e0e0; border-radius: 4px;"></div>
                    <div class="skeleton-title" style="height: 14px; width: 70%; background: #e0e0e0; border-radius: 4px;"></div>
                    <div class="skeleton-meta" style="height: 12px; width: 50%; background: #e0e0e0; border-radius: 4px; margin-top: 8px;"></div>
                </div>
            </article>
        </div>
    </div>
    @endfor
</div>

<style>
    @keyframes skeleton-loading {
        0% { opacity: 1; }
        50% { opacity: 0.5; }
        100% { opacity: 1; }
    }
    
    .skeleton-image,
    .skeleton-title,
    .skeleton-meta {
        animation: skeleton-loading 1.2s ease-in-out infinite;
    }
</style>