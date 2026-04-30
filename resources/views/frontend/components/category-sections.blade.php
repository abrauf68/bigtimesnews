@foreach($categories as $category)
<div class="section panel overflow-hidden category-section" data-category-slug="{{ $category->slug }}" data-category-id="{{ $category->id }}">
    <div class="section-outer panel py-5 lg:py-8">
        <div class="container max-w-xl">
            <div class="section-inner">
                <div class="block-layout grid-layout vstack gap-3 lg:gap-4 panel overflow-hidden">
                    <div class="block-header panel border-top pt-1">
                        <h2 class="h4 xl:h3 -ls-1 xl:-ls-2 m-0 text-inherit hstack gap-1">
                            <span class="panel d-inline-block bg-primary w-8px h-8px translate-y-px"></span>
                            <a class="text-none hover:text-primary duration-150" href="{{ route('category.detail', $category->slug) }}">{{ $category->name }}</a>
                        </h2>
                    </div>
                    <div class="block-content" id="category-content-{{ $category->id }}">
                        <!-- Skeleton Loader -->
                        <div class="category-skeleton" id="skeleton-{{ $category->id }}">
                            <div class="panel row child-cols-12 md:child-cols gy-4 md:gx-3 xl:gx-4">
                                <div class="col-12 md:col-6 lg:col-7">
                                    <div class="skeleton-card">
                                        <div class="skeleton-image" style="height: 200px; background: #e0e0e0; border-radius: 8px; animation: pulse 1.5s ease-in-out infinite;"></div>
                                        <div class="skeleton-title" style="height: 20px; background: #e0e0e0; margin-top: 12px; width: 80%; border-radius: 4px;"></div>
                                        <div class="skeleton-text" style="height: 60px; background: #e0e0e0; margin-top: 8px; border-radius: 4px;"></div>
                                    </div>
                                </div>
                                <div class="col-12 md:col-6 lg:col-5">
                                    <div class="vstack gap-3">
                                        @for($i = 0; $i < 4; $i++)
                                        <div class="skeleton-list-item">
                                            <div class="row g-2">
                                                <div class="col-auto">
                                                    <div class="skeleton-thumb" style="width: 100px; height: 70px; background: #e0e0e0; border-radius: 6px;"></div>
                                                </div>
                                                <div class="col">
                                                    <div class="skeleton-title" style="height: 16px; background: #e0e0e0; width: 90%; margin-bottom: 8px; border-radius: 4px;"></div>
                                                    <div class="skeleton-date" style="height: 12px; background: #e0e0e0; width: 60%; border-radius: 4px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Dynamic Content Loader -->
                        <div class="category-posts-container" id="posts-container-{{ $category->id }}" style="display: none;"></div>

                        <!-- Load More Trigger -->
                        <div class="infinite-scroll-trigger" data-category="{{ $category->slug }}" data-page="1" data-has-more="true" style="height: 20px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach

<style>
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}
</style>
