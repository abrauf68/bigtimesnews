@extends('frontend.layouts.master')

@section('title', $post->title)
@section('meta_title', $post->meta_title)
@section('meta_description', $post->meta_description)
@section('meta_keywords', $post->meta_keywords)
@section('author', $post->author->name ?? '')
@section('og_type', 'article')
@if ($post->meta_image)
    @section('og_image', asset($post->meta_image))
@elseif ($post->main_image)
    @section('og_image', asset($post->main_image))
@endif

@push('schema')
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "NewsArticle",
            "headline": {!! json_encode($post->title) !!},
            "description": {!! json_encode($post->meta_description) !!},
            "image": [{!! json_encode($post->main_image ? asset($post->main_image) : url('assets/img/social-og.png')) !!}],
            "datePublished": {!! json_encode(optional($post->published_at ?? $post->created_at)->toAtomString()) !!},
            "dateModified": {!! json_encode(optional($post->updated_at)->toAtomString()) !!},
            "author": {
                "@@type": "Person",
                "name": {!! json_encode($post->author->name ?? \App\Helpers\Helper::getCompanyName()) !!}
            },
            "publisher": {
                "@@type": "Organization",
                "name": {!! json_encode(\App\Helpers\Helper::getCompanyName()) !!},
                "logo": {
                    "@@type": "ImageObject",
                    "url": {!! json_encode(\App\Helpers\Helper::getLogoLight()) !!}
                }
            },
            "mainEntityOfPage": {
                "@@type": "WebPage",
                "@@id": {!! json_encode(request()->fullUrl()) !!}
            }
        }
    </script>
    <script type="application/ld+json">
        {
            "@@context": "https://schema.org",
            "@@type": "BreadcrumbList",
            "itemListElement": [
                {"@@type": "ListItem", "position": 1, "name": "Home", "item": {!! json_encode(route('frontend.home')) !!}},
                {"@@type": "ListItem", "position": 2, "name": "News", "item": {!! json_encode(route('frontend.news.index')) !!}},
                {"@@type": "ListItem", "position": 3, "name": {!! json_encode($post->category->name ?? '') !!}, "item": {!! json_encode($post->category ? route('frontend.news.category', $post->category->slug) : route('frontend.news.index')) !!}},
                {"@@type": "ListItem", "position": 4, "name": {!! json_encode($post->title) !!}}
            ]
        }
    </script>
@endpush

@section('css')
<style>
.skeleton-post-nav, .skeleton-related, .skeleton-comments {
    animation: pulse 1.5s ease-in-out infinite;
}
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}
.post-content h1, .post-content h2, .post-content h3, .post-content h4, .post-content h5, .post-content h6, .post-content p, .post-content li{
    color: #000 !important;
}
.footer-copyright p {
    color: #fff !important;
}

/* AI-generated article tables */
.post-content table {
    margin: 1.75rem 0;
    border-collapse: collapse;
    border: 1px solid #e5e7eb;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    font-size: 0.95rem;
    line-height: 1.5;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
}
.post-content table thead th {
    color: #000 !important;
    font-weight: 600;
    text-align: left;
    padding: 12px 16px;
    border: none;
}
.post-content table tbody td,
.post-content table tbody th {
    padding: 12px 16px;
    border-top: 1px solid #e5e7eb;
    color: #1f2937 !important;
    vertical-align: top;
}
/* .post-content table tbody tr:nth-child(even) {
    background-color: #f9fafb;
} */
.post-content table tbody tr:hover {
    background-color: #f3f4f6;
}
@media (max-width: 576px) {
    .post-content table {
        font-size: 0.85rem;
    }
    .post-content table thead th,
    .post-content table tbody td,
    .post-content table tbody th {
        padding: 8px 10px;
    }
}

/* Comment section */
.comments-list {
    background: #fff;
    border: 1px solid #eceef1;
    border-radius: 10px;
    padding: 20px 20px 4px;
}
.comment-card {
    display: flex;
    gap: 14px;
    padding: 16px 0;
    border-bottom: 1px solid #eceef1;
}
.comment-card-replies > .comment-card:last-child {
    border-bottom: none;
}
.comments-list > .comment-card:last-child {
    border-bottom: none;
}
.comment-card-avatar {
    flex: 0 0 auto;
}
.comment-card-avatar img {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    object-fit: cover;
    display: block;
}
.comment-card-body {
    flex: 1 1 auto;
    min-width: 0;
}
.comment-card-head {
    display: flex;
    align-items: baseline;
    gap: 8px;
    flex-wrap: wrap;
}
.comment-card-name {
    font-weight: 700;
    color: #16181b !important;
    font-size: 0.95rem;
}
.comment-card-time {
    color: #8a8f98;
    font-size: 0.8rem;
}
.comment-card-text {
    margin-top: 4px;
    color: #3c4149 !important;
    font-size: 0.92rem;
    line-height: 1.55;
    word-break: break-word;
}
.comment-card-actions {
    margin-top: 8px;
    display: flex;
    gap: 14px;
}
.comment-card-reply {
    font-size: 0.8rem;
    font-weight: 600;
    color: #6b7280 !important;
    text-decoration: none;
}
.comment-card-reply:hover {
    color: #2563eb !important;
    text-decoration: underline;
}
.comment-card-replies {
    margin-top: 8px;
    padding-left: 20px;
    border-left: 2px solid #eceef1;
}

/* Like button */
.like-button .like-icon {
    transition: color 0.15s ease, transform 0.15s ease;
}
.like-button.liked .like-icon {
    color: #e0245e !important;
    transform: scale(1.1);
}
.like-button.liked .likes-count {
    color: #e0245e !important;
}
</style>
@endsection

@section('breadcrumb-items')
@endsection

@section('content')
<div class="breadcrumbs panel z-1 py-2 bg-gray-25 dark:bg-gray-100 dark:bg-opacity-5 dark:text-white">
    <div class="container max-w-xl">
        <ul class="breadcrumb nav-x justify-center gap-1 fs-7 sm:fs-6 m-0">
            <li><a href="{{ route('frontend.home') }}">Home</a></li>
            <li><i class="unicon-chevron-right opacity-50"></i></li>
            <li><a href="{{ route('frontend.news.index') }}">News</a></li>
            <li><i class="unicon-chevron-right opacity-50"></i></li>
            <li><a href="{{ route('frontend.news.category', $post->category->slug) }}">{{ $post->category->name }}</a></li>
            <li><i class="unicon-chevron-right opacity-50"></i></li>
            <li><span class="opacity-50">{{ $post->title }}</span></li>
        </ul>
    </div>
</div>

<article class="post type-post single-post py-4 lg:py-6 xl:py-9">
    <div class="container max-w-xl">
        <div class="post-header">
            <div class="panel vstack gap-4 md:gap-6 xl:gap-8 text-center">
                <div class="panel vstack items-center max-w-400px sm:max-w-500px xl:max-w-md mx-auto gap-2 md:gap-3">
                    <h1 class="h4 sm:h2 lg:h1 xl:display-6">{{ $post->title }}</h1>
                    <ul class="post-share-icons nav-x gap-1 dark:text-white">
                        <li><a class="btn btn-md p-0 border-gray-900 border-opacity-15 w-32px lg:w-48px h-32px lg:h-48px text-dark dark:text-white dark:border-white hover:bg-primary hover:border-primary hover:text-white rounded-circle" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"><i class="unicon-logo-facebook icon-1"></i></a></li>
                        <li><a class="btn btn-md p-0 border-gray-900 border-opacity-15 w-32px lg:w-48px h-32px lg:h-48px text-dark dark:text-white dark:border-white hover:bg-primary hover:border-primary hover:text-white rounded-circle" href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(request()->fullUrl()) }}"><i class="unicon-logo-x-filled icon-1"></i></a></li>
                        <li><a class="btn btn-md p-0 border-gray-900 border-opacity-15 w-32px lg:w-48px h-32px lg:h-48px text-dark dark:text-white dark:border-white hover:bg-primary hover:border-primary hover:text-white rounded-circle" href="#"><i class="unicon-link icon-1"></i></a></li>
                    </ul>
                </div>
                @if(isset($post->main_image))
                <figure class="featured-image m-0">
                    <figure class="featured-image m-0 ratio ratio-2x1 rounded uc-transition-toggle overflow-hidden bg-gray-25 dark:bg-gray-800">
                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque"
                            src="{{ asset($post->main_image) }}" alt="{{ $post->title }}"
                            data-uc-img="loading: lazy">
                    </figure>
                </figure>
                @endif
            </div>
        </div>
    </div>
    <div class="panel mt-4 lg:mt-6 xl:mt-9">
        <div class="container max-w-lg">
            <div class="post-content panel fs-6 md:fs-5" data-uc-lightbox="animation: scale mb-2">
                {!! $post->content !!}
                <!-- Try these unicon variants -->
                <div class="post-stats panel hstack justify-center gap-4 mt-2 mb-2">
                    <div class="hstack gap-2">
                        <button class="like-button btn btn-sm p-0 text-none hstack gap-1" data-post-id="{{ $post->id }}" style="background: none; border: none; cursor: pointer;">
                            <i class="unicon-favorite icon-1 like-icon"></i>
                            <span id="likes-count-{{ $post->id }}" class="likes-count">{{ $post->likes_count ?? 0 }}</span>
                        </button>
                    </div>
                    <div class="hstack gap-2">
                        <i class="unicon-chat icon-1"></i>
                        <span id="comments-count">{{ $post->comments_count ?? 0 }}</span>
                    </div>
                    <div class="hstack gap-2">
                        <i class="unicon-view icon-1"></i>
                        <span id="views-count">{{ $post->views ?? 0 }}</span>
                    </div>
                </div>
            </div>

            <div class="post-footer panel vstack sm:hstack gap-3 justify-between justifybetween border-top py-1">
                <ul class="nav-x gap-narrow text-primary">
                    <li><span class="text-black dark:text-white me-narrow">Tags:</span></li>
                    @foreach (json_decode($post->tags ?? '[]') as $tag)
                        <li><a href="#" class="uc-link gap-0 dark:text-white">{{ $tag }} <span class="text-black dark:text-white">,</span></a></li>
                    @endforeach
                </ul>
                <ul class="post-share-icons nav-x gap-narrow">
                    <li class="me-1"><span class="text-black dark:text-white">Share:</span></li>
                    <li><a class="btn btn-md btn-outline-gray-100 p-0 w-32px lg:w-40px h-32px lg:h-40px text-dark dark:text-white dark:border-gray-600 hover:bg-primary hover:border-primary hover:text-white rounded-circle" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"><i class="unicon-logo-facebook icon-1"></i></a></li>
                    <li><a class="btn btn-md btn-outline-gray-100 p-0 w-32px lg:w-40px h-32px lg:h-40px text-dark dark:text-white dark:border-gray-600 hover:bg-primary hover:border-primary hover:text-white rounded-circle" href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(request()->fullUrl()) }}"><i class="unicon-logo-x-filled icon-1"></i></a></li>
                    <li><a class="btn btn-md btn-outline-gray-100 p-0 w-32px lg:w-40px h-32px lg:h-40px text-dark dark:text-white dark:border-gray-600 hover:bg-primary hover:border-primary hover:text-white rounded-circle" href="#"><i class="unicon-link icon-1"></i></a></li>
                </ul>
            </div>

            <!-- Post Navigation (AJAX Loaded) -->
            <div class="post-navigation panel vstack sm:hstack justify-between gap-2 mt-2 md:wrap" id="post-navigation-container">
                <div class="w-100 lg:w-1/2 skeleton-post-nav" style="height: 100px; background: #e0e0e0; border-radius: 8px;"></div>
                <div class="w-100 lg:w-1/2 skeleton-post-nav" style="height: 100px; background: #e0e0e0; border-radius: 8px;"></div>
            </div>

            <!-- Related Posts (AJAX Loaded) -->
            <div class="post-related panel border-top pt-2 mt-5">
                <h4 class="h5 xl:h4 mb-5 xl:mb-6">Related to this topic:</h4>
                <div id="related-posts-container">
                    <div class="row child-cols-6 md:child-cols-3 gx-2 gy-4 sm:gx-3 sm:gy-6">
                        @for($i = 0; $i < 4; $i++)
                        <div>
                            <div class="skeleton-related" style="height: 220px; background: #e0e0e0; border-radius: 8px;"></div>
                        </div>
                        @endfor
                    </div>
                </div>
            </div>

            <!-- Comments Section (AJAX Loaded) -->
            <div id="comments-section">
                <div id="comments-container">
                    <div class="skeleton-comments">
                        <div style="height: 40px; background: #e0e0e0; width: 200px; margin-bottom: 20px;"></div>
                        @for($i = 0; $i < 3; $i++)
                        <div style="height: 120px; background: #e0e0e0; margin-bottom: 20px; border-radius: 8px;"></div>
                        @endfor
                    </div>
                </div>

                <div id="comment-form-wrapper" class="panel pt-2 mt-8 xl:mt-9">
                    <h4 class="h5 xl:h4 mb-5 xl:mb-6">Leave a Comment</h4>
                    <div id="reply-indicator" class="alert alert-light border d-none align-items-center justify-content-between mb-3 py-2 px-3">
                        <span>Replying to <strong id="reply-indicator-name"></strong></span>
                        <a href="#" id="cancel-reply" class="fs-7">Cancel</a>
                    </div>
                    <div class="comment_form_holder">
                        <form id="comment-form" class="vstack gap-2">
                            @csrf
                            <input type="hidden" name="parent_id" id="comment-parent-id" value="">
                            <input class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30" type="text" name="name" placeholder="Your name" required>
                            <input class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30" type="email" name="email" placeholder="Your email" required>
                            <textarea class="form-control h-250px w-full fs-6 bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30" name="comment" placeholder="Your comment" required></textarea>
                            <button class="btn btn-primary btn-sm mt-1" type="submit">Post Comment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</article>
@endsection

@section('script')
<script>
// Store post ID
const postId = {{ $post->id }};

// Initialize AJAX loading
document.addEventListener('DOMContentLoaded', function() {
    loadPostNavigation();
    loadRelatedPosts();
    loadComments();
    setupCommentForm();
    setupLikeButton();
});

function setupLikeButton() {
    const btn = document.querySelector(`.like-button[data-post-id="${postId}"]`);
    if (!btn) return;

    fetch(`/api/post/${postId}/like-status`)
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                updateLikeButtonState(btn, data.liked, data.likes_count);
            }
        })
        .catch(() => {});

    btn.addEventListener('click', async () => {
        btn.disabled = true;
        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const response = await fetch(`/api/post/${postId}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await response.json();
            if (data.success) {
                updateLikeButtonState(btn, data.liked, data.likes_count);
            }
        } catch (error) {
            console.error('Error toggling like:', error);
        } finally {
            btn.disabled = false;
        }
    });
}

function updateLikeButtonState(btn, liked, count) {
    const icon = btn.querySelector('.like-icon');
    const countEl = btn.querySelector('.likes-count');

    if (icon) icon.classList.toggle('liked', liked);
    if (countEl) countEl.textContent = count;
    btn.classList.toggle('liked', liked);
}

// Load Prev/Next Posts
async function loadPostNavigation() {
    try {
        const response = await fetch(`/api/post/${postId}/navigation`);
        const data = await response.json();

        if (data.success) {
            const container = document.getElementById('post-navigation-container');
            let html = '';

            if (data.has_prev) {
                html += data.prev_html;
            } else {
                html += '<div class="w-100 lg:w-1/2"></div>';
            }

            if (data.has_next) {
                html += data.next_html;
            } else {
                html += '<div class="w-100 lg:w-1/2"></div>';
            }

            container.innerHTML = html;
        }
    } catch (error) {
        console.error('Error loading navigation:', error);
    }
}

// Load Related Posts
async function loadRelatedPosts() {
    try {
        const response = await fetch(`/api/post/${postId}/related`);
        const data = await response.json();

        if (data.success && data.html) {
            document.getElementById('related-posts-container').innerHTML = data.html;

            // Initialize UIkit lazy loading
            if (window.UIkit) {
                window.UIkit.update(document.getElementById('related-posts-container'));
            }
        }
    } catch (error) {
        console.error('Error loading related posts:', error);
    }
}

// Load Comments
let currentCommentPage = 1;
let hasMoreComments = true;

async function loadComments(page = 1) {
    try {
        const response = await fetch(`/api/post/${postId}/comments?page=${page}`);
        const data = await response.json();

        if (data.success && data.html) {
            if (page === 1) {
                document.getElementById('comments-container').innerHTML = data.html;
            } else {
                const list = document.querySelector('#comments-container .comments-list');
                if (list) {
                    list.insertAdjacentHTML('beforeend', data.html);
                } else {
                    document.getElementById('comments-container').insertAdjacentHTML('beforeend', data.html);
                }
            }
            hasMoreComments = data.has_more;
            currentCommentPage = data.next_page;

            const loadMoreBtn = document.querySelector('.load-more-comments');
            if (loadMoreBtn) {
                if (hasMoreComments) {
                    loadMoreBtn.dataset.page = currentCommentPage;
                } else {
                    loadMoreBtn.remove();
                }
            }

            if (page === 1 && hasMoreComments) {
                setupLoadMoreButton();
            }
        }
    } catch (error) {
        console.error('Error loading comments:', error);
    }
}

function setupLoadMoreButton() {
    const loadMoreBtn = document.querySelector('.load-more-comments');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', () => {
            if (hasMoreComments) {
                loadComments(currentCommentPage);
            }
        });
    }
}

// Setup Comment Form Submission
function setupCommentForm() {
    const form = document.getElementById('comment-form');
    if (!form) {
        console.log('Comment form not found');
        return;
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const submitBtn = form.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Submitting...';

        // Get form data
        const name = form.querySelector('input[name="name"]')?.value;
        const email = form.querySelector('input[name="email"]')?.value;
        const comment = form.querySelector('textarea[name="comment"]')?.value;
        const parentId = form.querySelector('#comment-parent-id')?.value || null;

        // Validate
        if (!name || !email || !comment) {
            alert('Please fill in all fields');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
            return;
        }

        // Get CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

        try {
            const response = await fetch(`/api/post/${postId}/comment`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    comment: comment,
                    parent_id: parentId
                })
            });

            const data = await response.json();

            if (data.success) {
                // Show success message
                const successMsg = document.createElement('div');
                successMsg.className = 'alert alert-success mt-3';
                successMsg.innerHTML = data.message || 'Comment submitted successfully! It will appear after moderation.';
                form.insertAdjacentElement('beforebegin', successMsg);

                // Reset form
                form.reset();
                cancelReply();

                // Remove success message after 5 seconds
                setTimeout(() => successMsg.remove(), 5000);

                // Reload comments after 2 seconds
                setTimeout(() => {
                    if (typeof loadComments === 'function') {
                        loadComments(1);
                    }
                }, 2000);
            } else {
                alert(data.message || 'Error submitting comment');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error submitting comment. Please try again.');
        } finally {
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        }
    });
}

// Reply to comment function
function replyToComment(commentId, userName) {
    const parentIdField = document.getElementById('comment-parent-id');
    const indicator = document.getElementById('reply-indicator');
    const indicatorName = document.getElementById('reply-indicator-name');
    const commentField = document.querySelector('#comment-form textarea[name="comment"]');

    if (parentIdField) parentIdField.value = commentId;
    if (indicatorName) indicatorName.textContent = userName;
    if (indicator) indicator.classList.remove('d-none');
    if (indicator) indicator.classList.add('d-flex');

    document.getElementById('comment-form-wrapper')?.scrollIntoView({ behavior: 'smooth', block: 'start' });

    if (commentField) {
        commentField.focus();
    }
}

function cancelReply() {
    const parentIdField = document.getElementById('comment-parent-id');
    const indicator = document.getElementById('reply-indicator');

    if (parentIdField) parentIdField.value = '';
    if (indicator) {
        indicator.classList.add('d-none');
        indicator.classList.remove('d-flex');
    }
}

document.getElementById('cancel-reply')?.addEventListener('click', (e) => {
    e.preventDefault();
    cancelReply();
});
</script>
@endsection
