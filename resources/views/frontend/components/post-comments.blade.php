@if($comments->count() > 0)
<h4 class="h5 xl:h4 mb-5 xl:mb-6">Comments ({{ $comments->total() }})</h4>
<div class="spacer-half"></div>

<ol class="comments-list">
    @foreach($comments as $comment)
    <li id="comment-{{ $comment->id }}">
        <div class="avatar">
            <img src="https://www.gravatar.com/avatar/{{ md5($comment->user_email) }}?s=50&d=mp" alt="{{ $comment->user_name }}">
        </div>
        <div class="comment-info">
            <span class="c_name">{{ $comment->user_name }}</span>
            <span class="c_date id-color">{{ $comment->created_at->diffForHumans() }}</span>
            <span class="c_reply"><a href="#" onclick="replyToComment('{{ $comment->id }}', '{{ $comment->user_name }}'); return false;">Reply</a></span>
            <div class="clearfix"></div>
        </div>
        <div class="comment">{{ nl2br(e($comment->content)) }}</div>

        @if($comment->replies && $comment->replies->count() > 0)
        <ol>
            @foreach($comment->replies as $reply)
            <li>
                <div class="avatar">
                    <img src="https://www.gravatar.com/avatar/{{ md5($reply->user_email) }}?s=50&d=mp" alt="{{ $reply->user_name }}">
                </div>
                <div class="comment-info">
                    <span class="c_name">{{ $reply->user_name }}</span>
                    <span class="c_date id-color">{{ $reply->created_at->diffForHumans() }}</span>
                    <div class="clearfix"></div>
                </div>
                <div class="comment">{{ nl2br(e($reply->content)) }}</div>
            </li>
            @endforeach
        </ol>
        @endif
    </li>
    @endforeach
</ol>

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
