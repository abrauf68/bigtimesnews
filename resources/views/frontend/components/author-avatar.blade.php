@php $px = (int) ($size ?? 24); $author = $author ?? null; @endphp
@if ($author && $author->photo_url)
    <img src="{{ $author->photo_url }}" alt="{{ $author->name }}" width="{{ $px }}" height="{{ $px }}"
        class="rounded-circle" style="width:{{ $px }}px;height:{{ $px }}px;object-fit:cover;" loading="lazy">
@elseif ($author)
    <span class="rounded-circle d-inline-flex items-center justify-center fw-bold flex-shrink-0" aria-hidden="true"
        style="width:{{ $px }}px;height:{{ $px }}px;background:#2757fd;color:#fff;font-size:{{ max(9, round($px * 0.4)) }}px;line-height:1;align-items:center;justify-content:center;">{{ $author->initials }}</span>
@endif
