<div class="row child-cols-12 gx-4 gy-3 sep-x">
    @for($i = 1; $i <= 4; $i++)
    <div>
        <div class="skeleton-popular-item">
            <div class="hstack gap-3">
                <span class="skeleton-number" style="width: 30px; height: 40px; background: #e0e0e0; border-radius: 4px;"></span>
                <div style="flex: 1;">
                    <div class="skeleton-title" style="width: 90%; height: 18px; background: #e0e0e0; border-radius: 4px; margin-bottom: 8px;"></div>
                    <div class="skeleton-meta" style="width: 60%; height: 14px; background: #e0e0e0; border-radius: 4px;"></div>
                </div>
            </div>
        </div>
    </div>
    @endfor
</div>

<style>
.skeleton-popular-item {
    animation: skeleton-fade 1.2s ease-in-out infinite;
}
@keyframes skeleton-fade {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}
</style>