@foreach($comments as $comment)
    @include('frontend.components.comment-item', ['comment' => $comment, 'depth' => 0])
@endforeach
