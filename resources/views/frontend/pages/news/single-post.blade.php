@extends('frontend.layouts.master')

@section('title', $post->title)
@section('meta_title', $post->meta_title)
@section('meta_description', $post->meta_description)
@section('meta_keywords', $post->meta_keywords)
@section('author', $post->author->name ?? '')

@section('css')
<style>
.skeleton-post-nav, .skeleton-related, .skeleton-comments {
    animation: pulse 1.5s ease-in-out infinite;
}
@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
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
                    <div class="comment_form_holder">
                        <form id="comment-form" class="vstack gap-2">
                            @csrf
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
});

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
                document.getElementById('comments-container').insertAdjacentHTML('beforeend', data.html);
            }
            hasMoreComments = data.has_more;
            currentCommentPage = data.next_page;

            // Setup load more button
            if (hasMoreComments) {
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
                loadMoreBtn.remove();
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
                    comment: comment
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
    const commentField = document.querySelector('#comment-form textarea[name="comment"]');
    if (commentField) {
        commentField.value = `@${userName} `;
        commentField.focus();
    }
}
</script>
@endsection
