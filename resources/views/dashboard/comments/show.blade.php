@extends('layouts.master')

@section('title', __('Comment Details'))

@section('css')
    <style>
        .comment-card {
            border-left: 4px solid #7367f0;
            background: #f8f9fc;
        }
        .reply-card {
            background: #ffffff;
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }
        .reply-card:hover {
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }
        .admin-reply {
            background: #f0f7ff;
            border-left: 3px solid #28c76f;
        }
        .comment-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #7367f0;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .status-badge {
            cursor: pointer;
            transition: opacity 0.2s;
        }
        .status-badge:hover {
            opacity: 0.8;
        }
        .reply-form {
            display: none;
            margin-top: 20px;
            padding: 20px;
            background: #f8f9fc;
            border-radius: 8px;
        }
        .reply-form.show {
            display: block;
        }
        .delete-reply {
            cursor: pointer;
        }
    </style>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item">
        <a href="{{ route('dashboard.comments.index') }}">{{ __('Comments') }}</a>
    </li>
    <li class="breadcrumb-item active">{{ __('Comment Details') }}</li>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-0">{{ __('Comment Details') }}</h5>
                            <small class="text-muted">Post: {{ $comment->post->title ?? 'N/A' }}</small>
                        </div>
                        <div>
                            <a href="{{ route('dashboard.comments.index') }}" class="btn btn-secondary">
                                <i class="ti ti-arrow-left me-1"></i> Back to Comments
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Comment -->
            <div class="col-12 mb-4">
                <div class="card comment-card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center">
                                <div class="comment-avatar me-3">
                                    {{ substr($comment->user->name ?? 'Guest', 0, 1) }}
                                </div>
                                <div>
                                    <h6 class="mb-0">{{ $comment->user->name ?? 'Guest User' }}</h6>
                                    <small class="text-muted">
                                        <i class="ti ti-calendar me-1"></i>
                                        {{ $comment->created_at->format('d M Y, h:i A') }}
                                    </small>
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <!-- Status Badge with Dropdown -->
                                <div class="dropdown">
                                    <span class="badge bg-label-{{ $comment->status == 'approved' ? 'success' : ($comment->status == 'pending' ? 'warning' : 'danger') }} status-badge dropdown-toggle"
                                          data-bs-toggle="dropdown"
                                          aria-expanded="false"
                                          style="cursor: pointer;">
                                        <i class="ti ti-status-change me-1"></i>
                                        {{ ucfirst($comment->status) }}
                                    </span>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item update-status" href="#" data-status="approved">
                                                <i class="ti ti-check text-success me-2"></i> Approved
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item update-status" href="#" data-status="pending">
                                                <i class="ti ti-clock text-warning me-2"></i> Pending
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item update-status" href="#" data-status="spam">
                                                <i class="ti ti-alert-circle text-danger me-2"></i> Spam
                                            </a>
                                        </li>
                                    </ul>
                                </div>

                                @can('delete comment')
                                    <button type="button" class="btn btn-icon btn-text-danger rounded-pill delete-comment"
                                            data-id="{{ $comment->id }}" data-bs-toggle="tooltip" title="Delete Comment">
                                        <i class="ti ti-trash ti-md"></i>
                                    </button>
                                @endcan
                            </div>
                        </div>

                        <div class="comment-content mt-3">
                            <p class="mb-0">{{ nl2br(e($comment->content)) }}</p>
                        </div>

                        <div class="mt-3">
                            <button type="button" class="btn btn-sm btn-primary btn-reply">
                                <i class="ti ti-reply me-1"></i> Reply to this comment
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Reply Form -->
            <div class="col-12 mb-4 reply-form" id="replyForm">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="ti ti-message-reply me-1"></i> Admin Reply
                        </h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('dashboard.comments.reply', $comment->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="content" class="form-label">Your Reply</label>
                                <textarea class="form-control @error('content') is-invalid @enderror"
                                          id="content"
                                          name="content"
                                          rows="4"
                                          placeholder="Write your reply here..."
                                          required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-send me-1"></i> Post Reply
                                </button>
                                <button type="button" class="btn btn-secondary cancel-reply">
                                    <i class="ti ti-x me-1"></i> Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Replies Section -->
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h6 class="card-title mb-0">
                            <i class="ti ti-messages me-1"></i>
                            Replies ({{ $comment->replies->count() }})
                        </h6>
                    </div>
                    <div class="card-body">
                        @if($comment->replies->count() > 0)
                            <div class="replies-list">
                                @foreach($comment->replies as $reply)
                                    <div class="reply-card card mb-3 {{ $reply->user && $reply->user->hasRole('admin') ? 'admin-reply' : '' }}"
                                         data-reply-id="{{ $reply->id }}">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div class="d-flex align-items-center">
                                                    <div class="comment-avatar me-3" style="width: 32px; height: 32px; font-size: 14px;">
                                                        {{ substr($reply->user->name ?? 'Admin', 0, 1) }}
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">
                                                            {{ $reply->user->name ?? 'Administrator' }}
                                                            @if($reply->user && $reply->user->hasRole('admin'))
                                                                <span class="badge bg-label-primary ms-2">Admin</span>
                                                            @endif
                                                        </h6>
                                                        <small class="text-muted">
                                                            <i class="ti ti-calendar me-1"></i>
                                                            {{ $reply->created_at->format('d M Y, h:i A') }}
                                                        </small>
                                                    </div>
                                                </div>
                                                @can('delete comment')
                                                    <button type="button" class="btn btn-icon btn-text-danger rounded-pill delete-reply"
                                                            data-id="{{ $reply->id }}" data-bs-toggle="tooltip" title="Delete Reply">
                                                        <i class="ti ti-trash ti-sm"></i>
                                                    </button>
                                                @endcan
                                            </div>
                                            <div class="mt-2">
                                                <p class="mb-0">{{ nl2br(e($reply->content)) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="ti ti-message-off ti-3x text-muted mb-2"></i>
                                <p class="text-muted mb-0">No replies yet. Be the first to reply!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Show/Hide Reply Form
            $('.btn-reply').on('click', function() {
                $('#replyForm').addClass('show');
                $('html, body').animate({
                    scrollTop: $('#replyForm').offset().top - 100
                }, 500);
            });

            $('.cancel-reply').on('click', function() {
                $('#replyForm').removeClass('show');
                $('#content').val('');
            });

            // Update Status via AJAX
            $('.update-status').on('click', function(e) {
                e.preventDefault();
                let status = $(this).data('status');
                let commentId = {{ $comment->id }};
                let statusText = $(this).text().trim();

                Swal.fire({
                    title: 'Change Status?',
                    text: `Do you want to mark this comment as ${statusText}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, change it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('dashboard.comments.status.ajax', $comment->id) }}",
                            type: 'PUT',
                            data: {
                                _token: '{{ csrf_token() }}',
                                status: status
                            },
                            success: function(response) {
                                if (response.success) {
                                    // Update badge
                                    let badge = $('.status-badge');
                                    badge.removeClass('bg-label-success bg-label-warning bg-label-danger');
                                    badge.addClass(response.badge_class);
                                    badge.html('<i class="ti ti-status-change me-1"></i> ' +
                                             status.charAt(0).toUpperCase() + status.slice(1));

                                    toastr.success(response.message);

                                    // Reload page after 1 second to show updated status in list
                                    setTimeout(() => {
                                        location.reload();
                                    }, 1000);
                                } else {
                                    toastr.error(response.message);
                                }
                            },
                            error: function(xhr) {
                                toastr.error('Failed to update status!');
                            }
                        });
                    }
                });
            });

            // Delete Main Comment
            $('.delete-comment').on('click', function(e) {
                e.preventDefault();
                let commentId = $(this).data('id');

                Swal.fire({
                    title: 'Delete Comment?',
                    text: "This will also delete all replies to this comment!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('dashboard.comments.destroy', $comment->id) }}",
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    toastr.success('Comment deleted successfully!');
                                    setTimeout(() => {
                                        window.location.href = "{{ route('dashboard.comments.index') }}";
                                    }, 1000);
                                } else {
                                    toastr.error('Failed to delete comment!');
                                }
                            },
                            error: function(xhr) {
                                toastr.error('Failed to delete comment!');
                            }
                        });
                    }
                });
            });

            // Delete Reply
            $('.delete-reply').on('click', function(e) {
                e.preventDefault();
                let replyId = $(this).data('id');
                let replyCard = $(this).closest('.reply-card');

                Swal.fire({
                    title: 'Delete Reply?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('dashboard.comments.reply.delete', '') }}/" + replyId,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if (response.success) {
                                    replyCard.fadeOut(300, function() {
                                        $(this).remove();
                                        // Update reply count
                                        let replyCount = $('.replies-list .reply-card').length;
                                        $('.card-header h6').html('<i class="ti ti-messages me-1"></i> Replies (' + replyCount + ')');

                                        if(replyCount === 0) {
                                            $('.card-body').html('<div class="text-center py-4"><i class="ti ti-message-off ti-3x text-muted mb-2"></i><p class="text-muted mb-0">No replies yet. Be the first to reply!</p></div>');
                                        }
                                    });
                                    toastr.success('Reply deleted successfully!');
                                } else {
                                    toastr.error('Failed to delete reply!');
                                }
                            },
                            error: function(xhr) {
                                toastr.error('Failed to delete reply!');
                            }
                        });
                    }
                });
            });

            // Initialize tooltips
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
@endsection
