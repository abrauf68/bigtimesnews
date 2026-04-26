<div class="skeleton-wrapper">
    <div class="row g-3">
        <!-- Left Sidebar Skeleton -->
        <div class="w-1/5">
            <div class="skeleton-nav">
                @for($i = 1; $i <= 6; $i++)
                    <div class="skeleton-line mb-3" style="width: 80%; height: 30px;"></div>
                @endfor
            </div>
        </div>

        <!-- Right Content Skeleton -->
        <div class="w-4/5">
            <div class="row child-cols g-3">
                @for($i = 1; $i <= 8; $i++)
                <div>
                    <div class="skeleton-card">
                        <div class="skeleton-image mb-2" style="height: 150px;"></div>
                        <div class="skeleton-title mb-2" style="width: 90%; height: 20px;"></div>
                        <div class="skeleton-title mb-2" style="width: 60%; height: 15px;"></div>
                        <div class="skeleton-meta" style="width: 40%; height: 12px;"></div>
                    </div>
                </div>
                @endfor
            </div>
        </div>
    </div>
</div>

<style>
.skeleton-wrapper {
    animation: skeleton-loading 1.2s ease-in-out infinite;
}

@keyframes skeleton-loading {
    0% { opacity: 1; }
    50% { opacity: 0.5; }
    100% { opacity: 1; }
}

.skeleton-nav, .skeleton-card {
    background: linear-gradient(
        90deg,
        #f0f0f0 25%,
        #e0e0e0 50%,
        #f0f0f0 75%
    );
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

.skeleton-line {
    background: #e0e0e0;
    border-radius: 4px;
}

.skeleton-image {
    background: #e0e0e0;
    border-radius: 8px;
}

.skeleton-title {
    background: #e0e0e0;
    border-radius: 4px;
}

.skeleton-meta {
    background: #e0e0e0;
    border-radius: 4px;
}
</style>
