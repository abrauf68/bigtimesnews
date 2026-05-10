<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('view comment');
        try {
            return view('dashboard.comments.index');
        } catch (\Throwable $th) {
            Log::error('Comments Index Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', "Something went wrong! Please try again later");
            throw $th;
        }
    }

    public function getCommentsData()
    {
        try {
            $comments = Comment::with(['post', 'user', 'parent'])->latest()->select('comments.*');

            return DataTables::of($comments)
                ->addIndexColumn()
                ->editColumn('content', function ($comment) {
                    return \Illuminate\Support\Str::limit(strip_tags($comment->content), 50, '...');
                })
                ->editColumn('post', function ($comment) {
                    return $comment->post ? '<a href="' . route('dashboard.posts.show', $comment->post_id) . '" target="_blank">' . \Illuminate\Support\Str::limit($comment->post->title, 30, '...') . '</a>' : 'N/A';
                })
                ->editColumn('user', function ($comment) {
                    return $comment->user ? $comment->user->name : 'Guest';
                })
                ->editColumn('created_at', function ($comment) {
                    return $comment->created_at->format('d M Y, h:i A');
                })
                ->editColumn('status', function ($comment) {
                    $badgeClass = $this->getStatusBadgeClass($comment->status);
                    return '<span class="badge me-4 bg-label-' . $badgeClass . '">' . ucfirst($comment->status) . '</span>';
                })
                ->addColumn('replies_count', function ($comment) {
                    $replyCount = $comment->replies()->count();
                    return $replyCount > 0 ? '<span class="badge bg-label-info">' . $replyCount . ' replies</span>' : '-';
                })
                ->addColumn('action', function ($comment) {
                    $actions = '';

                    // View Button
                    if (auth()->user()->can('view comment')) {
                        $actions .= '<span class="text-nowrap d-inline-block">
                                        <a href="' . route('dashboard.comments.show', $comment->id) . '" class="btn btn-icon btn-text-info waves-effect waves-light rounded-pill me-1" data-bs-toggle="tooltip" data-bs-placement="top" title="View Comment">
                                            <i class="ti ti-eye ti-md"></i>
                                        </a>
                                    </span>';
                    }

                    // Delete Button
                    if (auth()->user()->can('delete comment')) {
                        $actions .= '<form action="' . route('dashboard.comments.destroy', $comment->id) . '" method="POST" class="d-inline delete-form">
                                        <input type="hidden" name="_token" value="' . csrf_token() . '">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <a href="#" class="btn btn-icon btn-text-danger waves-effect waves-light rounded-pill delete_confirmation" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete Comment">
                                            <i class="ti ti-trash ti-md"></i>
                                        </a>
                                    </form>';
                    }

                    return $actions;
                })
                ->filterColumn('post', function ($query, $keyword) {
                    $query->whereHas('post', function ($q) use ($keyword) {
                        $q->where('title', 'like', "%{$keyword}%");
                    });
                })
                ->filterColumn('user', function ($query, $keyword) {
                    $query->whereHas('user', function ($q) use ($keyword) {
                        $q->where('name', 'like', "%{$keyword}%");
                    })->orWhereNull('user_id');
                })
                ->rawColumns(['content', 'post', 'status', 'replies_count', 'action'])
                ->make(true);
        } catch (\Throwable $th) {
            Log::error('Comments DataTable Failed', ['error' => $th->getMessage()]);
            return response()->json(['error' => 'Something went wrong!'], 500);
        }
    }

    private function getStatusBadgeClass($status)
    {
        switch ($status) {
            case 'approved':
                return 'success';
            case 'pending':
                return 'warning';
            case 'spam':
                return 'danger';
            case 'trash':
                return 'dark';
            default:
                return 'secondary';
        }
    }

    // Status update methods
    public function approve(Comment $comment)
    {
        $this->authorize('update comment');
        try {
            $comment->update([
                'status' => 'approved',
                'approved_at' => now()
            ]);

            return redirect()->back()->with('success', 'Comment approved successfully!');
        } catch (\Throwable $th) {
            Log::error('Comment Approve Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', 'Failed to approve comment!');
        }
    }

    public function markAsSpam(Comment $comment)
    {
        $this->authorize('update comment');
        try {
            $comment->update(['status' => 'spam']);
            return redirect()->back()->with('success', 'Comment marked as spam!');
        } catch (\Throwable $th) {
            Log::error('Comment Spam Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', 'Failed to mark comment as spam!');
        }
    }

    public function updateStatus(Comment $comment)
    {
        $this->authorize('update comment');
        try {
            if ($comment->status == 'approved') {
                $comment->update(['status' => 'pending', 'approved_at' => null]);
                $message = 'Comment moved to pending!';
            } else {
                $comment->update(['status' => 'approved', 'approved_at' => now()]);
                $message = 'Comment approved successfully!';
            }

            return redirect()->back()->with('success', $message);
        } catch (\Throwable $th) {
            Log::error('Comment Status Update Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', 'Failed to update comment status!');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        $this->authorize('view comment');

        // Load comment with replies and user data
        $comment->load(['user', 'post', 'replies.user']);

        return view('dashboard.comments.show', compact('comment'));
    }

    public function reply(Request $request, Comment $comment)
    {
        $this->authorize('create comment');

        $request->validate([
            'content' => 'required|string|min:2|max:1000'
        ]);

        try {
            $reply = Comment::create([
                'post_id' => $comment->post_id,
                'user_id' => auth()->id(),
                'content' => $request->content,
                'parent_id' => $comment->id,
                'status' => 'approved', // Admin replies are auto-approved
                'approved_at' => now()
            ]);

            return redirect()->back()->with('success', 'Reply added successfully!');
        } catch (\Throwable $th) {
            Log::error('Comment Reply Failed', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', 'Failed to add reply!');
        }
    }

    public function updateStatusAjax(Request $request, Comment $comment)
    {
        $this->authorize('update comment');

        try {
            $status = $request->status;
            $data = ['status' => $status];

            if ($status == 'approved') {
                $data['approved_at'] = now();
            } elseif ($status == 'pending') {
                $data['approved_at'] = null;
            }

            $comment->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Comment status updated successfully!',
                'status' => $status,
                'badge_class' => $this->getStatusBadgeClass($status)
            ]);
        } catch (\Throwable $th) {
            Log::error('Comment Status Update Failed', ['error' => $th->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to update comment status!'
            ], 500);
        }
    }

    public function deleteReply(Comment $reply)
    {
        $this->authorize('delete comment');

        try {
            $reply->delete();
            return response()->json([
                'success' => true,
                'message' => 'Reply deleted successfully!'
            ]);
        } catch (\Throwable $th) {
            Log::error('Reply Delete Failed', ['error' => $th->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete reply!'
            ], 500);
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete comment');

        try {
            // Delete all replies first
            $comment->replies()->delete();
            $comment->delete();

            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Comment deleted successfully!'
                ]);
            }

            return redirect()->back()->with('success', 'Comment deleted successfully!');
        } catch (\Throwable $th) {
            Log::error('Comment Delete Failed', ['error' => $th->getMessage()]);

            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete comment!'
                ], 500);
            }

            return redirect()->back()->with('error', 'Failed to delete comment!');
        }
    }
}
