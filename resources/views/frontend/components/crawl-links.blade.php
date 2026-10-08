{{-- Plain server-rendered links so search engines can follow them without running JavaScript --}}
@if (isset($links) && $links->isNotEmpty())
<section class="crawl-links panel border-top pt-3 mt-5 mb-4" aria-label="{{ $heading ?? 'More articles' }}">
    <div class="container max-w-xl">
        <h2 class="h5 mb-3">{{ $heading ?? 'More articles' }}</h2>
        <ul class="list-unstyled m-0 vstack gap-1">
            @foreach ($links as $item)
                @if ($item->category)
                <li>
                    <a class="text-none" href="{{ route('frontend.news.show', [$item->category->slug, $item->slug]) }}">{{ $item->title }}</a>
                    <span class="fs-7 opacity-60">— {{ $item->category->name }}</span>
                </li>
                @endif
            @endforeach
        </ul>
        <p class="mt-3 mb-0"><a class="fw-bold" href="{{ route('frontend.archive') }}">Browse all articles &raquo;</a></p>
    </div>
</section>
@endif
