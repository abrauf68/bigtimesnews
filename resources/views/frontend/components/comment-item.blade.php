@php $depth = $depth ?? 0; @endphp

<div class="comment-card" id="comment-{{ $comment->id }}">
    <div class="comment-card-avatar">
        <img src="{{ $comment->author_avatar }}" alt="{{ $comment->author_name }}">
    </div>
    <div class="comment-card-body">
        <div class="comment-card-head">
            <span class="comment-card-name">{{ $comment->author_name }}</span>
            <span class="comment-card-time">{{ $comment->created_at->diffForHumans() }}</span>
        </div>
        <div class="comment-card-text">{{ nl2br(e($comment->content)) }}</div>
        <div class="comment-card-actions">
            <a href="#comment-form" class="comment-card-reply"
                onclick="replyToComment('{{ $comment->id }}', '{{ addslashes($comment->author_name) }}'); return false;">Reply</a>
        </div>

        @if($comment->replies && $comment->replies->count() > 0)
            <div class="comment-card-replies">
                @foreach($comment->replies as $reply)
                    @include('frontend.components.comment-item', ['comment' => $reply, 'depth' => $depth + 1])
                @endforeach
            </div>
        @endif
    </div>
</div>
