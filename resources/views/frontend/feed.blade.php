<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom" xmlns:media="http://search.yahoo.com/mrss/" xmlns:dc="http://purl.org/dc/elements/1.1/">
    <channel>
        <title>{{ $siteName }}</title>
        <link>{{ url('/') }}</link>
        <description>{{ $siteName }}: US news, explainers and guides to upcoming dates.</description>
        <language>en-us</language>
        <lastBuildDate>{{ optional($posts->first()?->published_at)->toRssString() ?? now()->toRssString() }}</lastBuildDate>
        <ttl>15</ttl>
        <atom:link href="{{ url('/feed.xml') }}" rel="self" type="application/rss+xml" />
@foreach ($posts as $post)
        <item>
            <title>{{ $post->title }}</title>
            <link>{{ route('frontend.news.show', [$post->category->slug, $post->slug]) }}</link>
            <guid isPermaLink="true">{{ route('frontend.news.show', [$post->category->slug, $post->slug]) }}</guid>
            <pubDate>{{ $post->published_at->toRssString() }}</pubDate>
            <category>{{ $post->category->name }}</category>
            <description>{{ \App\Http\Controllers\Frontend\FeedController::summary($post) }}</description>
@if ($post->main_image)
            <media:content url="{{ asset($post->main_image) }}" medium="image" />
@endif
        </item>
@endforeach
    </channel>
</rss>
