{{-- Category Sections Container - Loaded via AJAX --}}
<div id="category-sections-container">
    <!-- Skeleton Loading -->
    <div class="section panel overflow-hidden">
        <div class="section-outer panel">
            <div class="container max-w-xl">
                <div class="section-inner">
                    <!-- First Row Skeleton -->
                    <div class="row child-cols-12 lg:child-cols g-4 lg:g-6 col-match">
                        <div class="lg:col-8">
                            <div class="skeleton-box">
                                <div class="skeleton-header"></div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="skeleton-image-large"></div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="skeleton-list">
                                            @for($i=1; $i<=4; $i++)
                                            <div class="skeleton-item"></div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-4">
                            <div class="skeleton-box">
                                <div class="skeleton-header"></div>
                                @for($i=1; $i<=4; $i++)
                                <div class="skeleton-item"></div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    
                    <!-- Second Row Skeleton -->
                    <div class="row child-cols-12 lg:child-cols g-4 lg:g-6 col-match mt-4">
                        @for($i=1; $i<=3; $i++)
                        <div class="lg:col-4">
                            <div class="skeleton-box">
                                <div class="skeleton-header"></div>
                                <div class="skeleton-image"></div>
                                @for($j=1; $j<=3; $j++)
                                <div class="skeleton-item-small"></div>
                                @endfor
                            </div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.skeleton-box {
    background: #f8f9fa;
    border-radius: 12px;
    padding: 20px;
    margin-bottom: 20px;
    animation: skeleton-fade 1.2s ease-in-out infinite;
}
.skeleton-header {
    height: 30px;
    background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
    background-size: 200% 100%;
    animation: skeleton-loading 1.5s infinite;
    width: 150px;
    border-radius: 4px;
    margin-bottom: 20px;
}
.skeleton-image-large {
    height: 300px;
    background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
    background-size: 200% 100%;
    animation: skeleton-loading 1.5s infinite;
    border-radius: 8px;
    margin-bottom: 15px;
}
.skeleton-image {
    height: 180px;
    background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
    background-size: 200% 100%;
    animation: skeleton-loading 1.5s infinite;
    border-radius: 8px;
    margin-bottom: 15px;
}
.skeleton-item {
    height: 60px;
    background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
    background-size: 200% 100%;
    animation: skeleton-loading 1.5s infinite;
    margin-bottom: 12px;
    border-radius: 8px;
}
.skeleton-item-small {
    height: 50px;
    background: linear-gradient(90deg, #e0e0e0 25%, #f0f0f0 50%, #e0e0e0 75%);
    background-size: 200% 100%;
    animation: skeleton-loading 1.5s infinite;
    margin-bottom: 10px;
    border-radius: 8px;
}
@keyframes skeleton-loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}
@keyframes skeleton-fade {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    loadCategorySections();
});

async function loadCategorySections() {
    const container = document.getElementById('category-sections-container');
    if (!container) return;
    
    try {
        const response = await fetch('/api/category-sections', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });
        
        if (!response.ok) throw new Error(`HTTP ${response.status}`);
        
        const data = await response.json();
        
        if (data.html) {
            container.style.transition = 'opacity 0.3s ease';
            container.style.opacity = '0';
            
            setTimeout(() => {
                container.innerHTML = data.html;
                container.style.opacity = '1';
                
                if (window.UIkit) {
                    window.UIkit.update(container);
                    window.UIkit.lazyLoad();
                }
            }, 150);
        }
    } catch (error) {
        console.error('Failed to load category sections:', error);
        container.innerHTML = '<div class="text-center py-5 text-danger">Failed to load content. <button onclick="location.reload()" class="btn btn-sm btn-primary">Retry</button></div>';
    }
}
</script>