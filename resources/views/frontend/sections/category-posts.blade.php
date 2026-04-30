<!-- Dynamic Category Sections with Infinite Scroll -->
<div id="dynamic-category-sections">
    <!-- Skeleton for all categories -->
    <div class="all-categories-skeleton">
        @for($i = 0; $i < 4; $i++)
        <div class="section panel overflow-hidden">
            <div class="section-outer panel py-5 lg:py-8">
                <div class="container max-w-xl">
                    <div class="section-inner">
                        <div class="block-layout grid-layout vstack gap-3 lg:gap-4 panel overflow-hidden">
                            <div class="block-header panel border-top pt-1">
                                <div class="skeleton-header" style="height: 30px; width: 200px; background: #e0e0e0; border-radius: 4px; animation: pulse 1.5s ease-in-out infinite;"></div>
                            </div>
                            <div class="block-content">
                                <div class="panel row child-cols-12 md:child-cols gy-4 md:gx-3 xl:gx-4">
                                    <div class="col-12 md:col-6 lg:col-7">
                                        <div class="skeleton-featured" style="height: 250px; background: #e0e0e0; border-radius: 8px; animation: pulse 1.5s ease-in-out infinite;"></div>
                                    </div>
                                    <div class="col-12 md:col-6 lg:col-5">
                                        <div class="vstack gap-3">
                                            @for($j = 0; $j < 4; $j++)
                                            <div class="skeleton-list" style="height: 80px; background: #e0e0e0; border-radius: 6px; animation: pulse 1.5s ease-in-out infinite;"></div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endfor
    </div>

    <!-- Categories will be loaded here -->
    <div id="categories-container"></div>
</div>

<style>
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}
</style>

@section('scripts')
<script>
// Load all categories dynamically
async function loadAllCategories() {
    const container = document.getElementById('categories-container');
    const skeleton = document.querySelector('.all-categories-skeleton');

    try {
        const response = await fetch('/api/all-categories-sections', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.html) {
            container.innerHTML = data.html;
            if (skeleton) skeleton.style.display = 'none';

            // Initialize infinite scroll for loaded categories
            if (typeof InfiniteCategoryScroll !== 'undefined') {
                new InfiniteCategoryScroll();
            }
        }
    } catch (error) {
        console.error('Error loading categories:', error);
        if (skeleton) {
            skeleton.innerHTML = '<div class="text-center py-5 text-danger">Error loading content. Please refresh the page.</div>';
        }
    }
}

// Load categories on page load
document.addEventListener('DOMContentLoaded', () => {
    loadAllCategories();
});
</script>
@endsection
