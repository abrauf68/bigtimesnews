{{-- resources/views/frontend/skeletons/category-block-large.blade.php --}}
<div class="block-layout grid-layout vstack gap-2 lg:gap-3 panel overflow-hidden">
    <div class="block-header panel pt-1 border-top">
        <div class="cs-skel skel-label"></div>
    </div>
    <div class="block-content">
        <div class="panel row child-cols-12 md:child-cols g-2 lg:g-4 col-match sep-y" data-uc-grid>
            {{-- Featured large card --}}
            <div class="col-12 md:col-6 order-0 md:order-1">
                <div class="cs-skel skel-img-tall w-100" style="min-height:260px"></div>
            </div>
            {{-- List of small articles --}}
            <div class="order-1 md:order-0">
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
    </div>
</div>