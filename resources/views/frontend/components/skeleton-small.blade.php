<div class="skeleton-small-wrapper">
    <div class="row g-2">
        @for($i = 1; $i <= 4; $i++)
        <div class="col-6 col-md-3">
            <div class="skeleton-small-card">
                <div class="skeleton-small-image mb-2"></div>
                <div class="skeleton-small-title mb-2"></div>
                <div class="skeleton-small-meta"></div>
            </div>
        </div>
        @endfor
    </div>
</div>

<style>
.skeleton-small-wrapper {
    animation: skeleton-fade 1.2s ease-in-out infinite;
}

@keyframes skeleton-fade {
    0% { opacity: 1; }
    50% { opacity: 0.6; }
    100% { opacity: 1; }
}

.skeleton-small-card {
    background: #f5f5f5;
    border-radius: 8px;
    padding: 10px;
}

.skeleton-small-image {
    background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
    background-size: 200% 100%;
    animation: skeleton-loading 1.5s infinite;
    height: 100px;
    border-radius: 6px;
}

.skeleton-small-title {
    background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
    background-size: 200% 100%;
    animation: skeleton-loading 1.5s infinite;
    height: 16px;
    border-radius: 4px;
    width: 90%;
}

.skeleton-small-meta {
    background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
    background-size: 200% 100%;
    animation: skeleton-loading 1.5s infinite;
    height: 12px;
    border-radius: 4px;
    width: 50%;
}

@keyframes skeleton-loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}
</style>
