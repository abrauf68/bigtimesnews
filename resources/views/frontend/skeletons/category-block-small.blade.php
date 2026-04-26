{{-- resources/views/frontend/skeletons/category-block-small.blade.php --}}
<div class="block-layout grid-layout vstack gap-2 lg:gap-3 panel overflow-hidden">
    <div class="block-header panel pt-1 border-top">
        <div class="cs-skel skel-label"></div>
    </div>
    <div class="block-content">
        <div class="row child-cols-12 g-2 lg:g-4 sep-x" data-uc-grid>
            @for($i = 0; $i < 4; $i++)
            <div>
                <div class="d-flex gap-2 align-items-start">
                    <div class="flex-fill">
                        <div class="cs-skel skel-title w-100"></div>
                        <div class="cs-skel skel-title w-75"></div>
                        <div class="cs-skel skel-text w-25 mt-1"></div>
                    </div>
                    <div class="cs-skel skel-img-sq flex-shrink-0"></div>
                </div>
            </div>
            @endfor
        </div>
    </div>
</div>