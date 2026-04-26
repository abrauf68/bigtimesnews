{{-- resources/views/frontend/components/posts-grid-only.blade.php --}}
@props(['posts'])

@if($posts->count() > 0)
    @foreach($posts as $post)
        <div class="col-3 col-md-4 col-lg-3">
            @include('frontend.components.post-card', ['post' => $post])
        </div>
    @endforeach
@else
    <div class="col-12 text-center py-5">
        <i class="unicon-inbox fs-1 text-gray-400"></i>
        <p class="mt-3 text-gray-500">No posts found in this category</p>
    </div>
@endif
