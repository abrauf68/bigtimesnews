<?php
// Get categories with 6+ posts for skeleton
use App\Models\Category;

$skeletonCategories = Category::where('is_active', 'active')
    ->withCount(['posts' => function($q) {
        $q->published();
    }])
    ->having('posts_count', '>=', 6)
    ->orderBy('name')
    ->get();
?>

<div class="category-posts-area mt-5">
    <div id="new-category-sections-container">
        <!-- Dynamic skeleton loader based on actual categories with 6+ posts -->
        @foreach($skeletonCategories as $category)
        <div class="section panel overflow-hidden mb-5" data-skeleton-category="{{ $category->slug }}">
            <div class="section-outer panel">
                <div class="container max-w-xl">
                    <div class="section-inner">
                        <div class="block-layout grid-layout vstack gap-3 lg:gap-4 panel overflow-hidden">
                            <div class="block-header panel border-top pt-1">
                                <div class="skeleton-header" style="height: 32px; width: 150px; background: #e0e0e0; border-radius: 4px; animation: pulse 1.5s ease-in-out infinite;"></div>
                            </div>
                            <div class="block-content">
                                <div class="panel row child-cols-12 md:child-cols gy-4 md:gx-3 xl:gx-4">
                                    <div class="col-12 md:col-6 lg:col-7">
                                        <div class="skeleton-featured" style="height: 280px; background: #e0e0e0; border-radius: 12px; animation: pulse 1.5s ease-in-out infinite;"></div>
                                    </div>
                                    <div class="col-12 md:col-6 lg:col-5">
                                        <div class="vstack gap-3">
                                            @for($j = 0; $j < 4; $j++)
                                            <div class="skeleton-list" style="height: 85px; background: #e0e0e0; border-radius: 8px; animation: pulse 1.5s ease-in-out infinite;"></div>
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
        @endforeach

        <!-- If no categories with 6+ posts, show default skeletons -->
        @if($skeletonCategories->count() == 0)
            @for($i = 0; $i < 3; $i++)
            <div class="section panel overflow-hidden mb-5">
                <div class="section-outer panel">
                    <div class="container max-w-xl">
                        <div class="section-inner">
                            <div class="block-layout grid-layout vstack gap-3 lg:gap-4 panel overflow-hidden">
                                <div class="block-header panel border-top pt-1">
                                    <div class="skeleton-header" style="height: 32px; width: 150px; background: #e0e0e0; border-radius: 4px; animation: pulse 1.5s ease-in-out infinite;"></div>
                                </div>
                                <div class="block-content">
                                    <div class="panel row child-cols-12 md:child-cols gy-4 md:gx-3 xl:gx-4">
                                        <div class="col-12 md:col-6 lg:col-7">
                                            <div class="skeleton-featured" style="height: 280px; background: #e0e0e0; border-radius: 12px; animation: pulse 1.5s ease-in-out infinite;"></div>
                                        </div>
                                        <div class="col-12 md:col-6 lg:col-5">
                                            <div class="vstack gap-3">
                                                @for($j = 0; $j < 4; $j++)
                                                <div class="skeleton-list" style="height: 85px; background: #e0e0e0; border-radius: 8px; animation: pulse 1.5s ease-in-out infinite;"></div>
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
        @endif
    </div>
</div>

<style>
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}
</style>
