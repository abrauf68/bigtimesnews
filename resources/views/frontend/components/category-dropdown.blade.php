@props(['posts', 'category'])

@if($posts->count() > 0)
    <div class="row g-3">
        @foreach($posts->take(8) as $post)
            <div class="col-3 col-md-4 col-lg-3">
                @include('frontend.components.post-card', ['post' => $post])
            </div>
        @endforeach
    </div>
@else
    <div class="text-center py-5">
        <i class="unicon-folder-open fs-1 text-gray-400"></i>
        <p class="mt-3 text-gray-500">No posts available in {{ $category->name }}</p>
    </div>
@endif
