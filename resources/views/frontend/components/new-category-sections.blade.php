<div id="new-category-sections-container">
    @foreach($categories as $category)
    <div class="section panel overflow-hidden new-category-wrapper mb-5"
         data-category-id="{{ $category->id }}"
         data-category-slug="{{ $category->slug }}"
         data-category-posts-count="{{ $category->posts_count }}">
        <div class="section-outer panel py-2 lg:py-2">
            <div class="container max-w-xl">
                <div class="section-inner">
                    <div class="block-layout grid-layout vstack gap-3 lg:gap-4 panel overflow-hidden">
                        <div class="block-header panel border-top pt-1">
                            <h2 class="h4 xl:h3 -ls-1 xl:-ls-2 m-0 text-inherit hstack gap-1">
                                <span class="panel d-inline-block bg-primary w-8px h-8px translate-y-px"></span>
                                <a class="text-none hover:text-primary duration-150" href="{{ route('frontend.news.category', $category->slug) }}">
                                    {{ $category->name }}
                                </a>
                                <span class="text-muted fs-6 ms-2">({{ $category->posts_count }} posts)</span>
                            </h2>
                        </div>
                        <div class="block-content">
                            <!-- Posts will load here -->
                            <div id="new-posts-{{ $category->id }}" class="new-posts-container">
                                <!-- Skeleton specific to this category -->
                                <div class="new-skeleton-{{ $category->id }}">
                                    <div class="panel row child-cols-12 md:child-cols gy-4 md:gx-3 xl:gx-4">
                                        <div class="col-12 md:col-6 lg:col-7">
                                            <div class="skeleton-featured" style="height: 250px; background: #e0e0e0; border-radius: 8px; animation: pulse 1.5s ease-in-out infinite;"></div>
                                        </div>
                                        <div class="col-12 md:col-6 lg:col-5">
                                            <div class="vstack gap-3">
                                                @for($i = 0; $i < 4; $i++)
                                                <div class="skeleton-list-item" style="height: 80px; background: #e0e0e0; border-radius: 6px; animation: pulse 1.5s ease-in-out infinite;"></div>
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- See All Button (initially hidden, shown after posts load) -->
                            <div class="see-all-btn-{{ $category->id }}" style="display: none;">
                                <a href="{{ route('frontend.news.category', $category->slug) }}" class="animate-btn gap-0 btn btn-sm btn-alt-primary bg-transparent dark:text-white border w-100 mt-4">
                                    <span>See all {{ $category->name }}</span>
                                    <i class="icon icon-1 unicon-chevron-right"></i>
                                </a>
                            </div>

                            <!-- Infinite scroll trigger (only show if has more than 5 posts) -->
                            @if($category->posts_count > 5)
                            <div class="infinite-trigger text-center py-3"
                                 data-category="{{ $category->slug }}"
                                 data-page="1"
                                 data-has-more="true"
                                 data-total-posts="{{ $category->posts_count }}"
                                 style="display: none;">
                                <div class="spinner-border text-primary spinner-border-sm" role="status">
                                    <span class="visually-hidden">Loading more posts...</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

<style>
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.6; }
}
</style>
