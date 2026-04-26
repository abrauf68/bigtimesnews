{{-- resources/views/frontend/components/posts-grid.blade.php --}}
<div class="row col-match g-2">
    <div class="w-1/5">
        <div class="uc-navbar-switcher-nav border-end">
            <ul class="uc-tab-left fs-6 text-end"
                data-uc-tab="connect: #uc-navbar-switcher-content; animation: uc-animation-slide-right-small, uc-animation-slide-left-small">
                <li><a href="#" data-category="all">All</a></li>
                @foreach($categories as $cat)
                    <li>
                        <a href="#" data-category="{{ $cat->slug }}">
                            {{ $cat->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="w-4/5">
        <div id="uc-navbar-switcher-content" class="uc-navbar-switcher uc-switcher">
            <!-- All Posts Panel -->
            <div class="row child-cols g-2" data-panel="all">
                @foreach($posts as $post)
                    <div class="col-3 col-md-4 col-lg-3">
                        @include('frontend.components.post-card', ['post' => $post])
                    </div>
                @endforeach
            </div>

            <!-- Category Panels -->
            @foreach($categories as $cat)
                <div class="row child-cols g-2" data-panel="{{ $cat->slug }}">
                    <!-- Posts will be loaded via AJAX -->
                    <div class="col-12 text-center py-5">
                        <div class="skeleton-loader">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2">Loading {{ $cat->name }} posts...</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
