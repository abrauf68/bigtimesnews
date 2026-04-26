@for($i = 1; $i <= 6; $i++)
<div class="skeleton-post-item">
    <article class="post type-post">
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
    </article>
</div>
@endfor

<style>
@keyframes skeleton-loading {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}
.skeleton-post-item {
    animation: skeleton-loading 1.2s ease-in-out infinite;
    margin-bottom: 30px;
    padding-bottom: 30px;
    border-bottom: 1px solid #eee;
}
.skeleton-image,
.skeleton-title,
.skeleton-meta,
.skeleton-text,
.skeleton-button {
    background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
    background-size: 200% 100%;
    animation: skeleton-shimmer 1.5s infinite;
}
@keyframes skeleton-shimmer {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}
</style>