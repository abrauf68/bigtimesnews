@if($comments->count() > 0)
<h4 class="h5 xl:h4 mb-5 xl:mb-6 mt-3">Comments ({{ $comments->total() }})</h4>
<div class="spacer-half"></div>

<div class="comments-list">
    @include('frontend.components.comments-list', ['comments' => $comments])
</div>

@if($comments->hasMorePages())
<div class="text-center mt-4">
    <button class="btn btn-sm btn-primary load-more-comments" data-page="{{ $comments->currentPage() + 1 }}">
        Load More Comments
    </button>
</div>
@endif

@else
<h4 class="h5 xl:h4 mb-5 xl:mb-6">Comments (0)</h4>
<div class="text-center py-5">
    <p>No comments yet. Be the first to comment!</p>
</div>
@endif
