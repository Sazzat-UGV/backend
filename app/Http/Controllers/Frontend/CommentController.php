<?php
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\CommentReaction;
use App\Models\CommentReply;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Number;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'video_id' => 'required|numeric|exists:videos,id',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        $comments = Comment::with('user:id,name,avatar')
            ->withCount('reactions')
            ->with(['reactions' => function ($query) {
                $query->where('user_id', Auth::id());
            }])
            ->where('video_id', $request->video_id)
            ->latest('id')
            ->paginate($request->per_page ?? 10);
        //total comment count
        $topLevelComments = Comment::where('video_id', $request->video_id)->count();
        $commentIds       = Comment::where('video_id', $request->video_id)->pluck('id');
        $replies          = CommentReply::whereIn('comment_id', $commentIds)->count();

        $total = $topLevelComments + $replies;

        $comments->getCollection()->transform(function ($c) {
            $c->reactions_count_format = Number::abbreviate($c->reactions_count);
            $c->created_at_format      = $c->created_at->diffForHumans();
            $c->is_react               = $c->reactions->isNotEmpty();
            unset($c->reactions);
            return $c;
        });

        $data = [
            'total_comment' => $total,
            'comments'      => $comments,
        ];
        return response()->json([
            'status'  => true,
            'message' => 'Comments retreived successfully.',
            'data'    => $data,
        ], 200);
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
        $validator = Validator::make($request->all(), [
            'video_id' => 'required|numeric|exists:videos,id',
            'comment'  => 'required|string',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        $comment           = new Comment();
        $comment->user_id  = Auth::user()->id;
        $comment->video_id = $request->video_id;
        $comment->comment  = $request->comment;
        $comment->save();
        return response()->json([
            'status'  => true,
            'message' => 'Comment created successfully.',
            'data'    => $comment,
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy(string $id)
    {
        try {
            $comment = Comment::findOrFail($id);
            $comment->delete();

            return response()->json([
                'status'  => true,
                'message' => 'Comment deleted successfully.',
                'data'    => $comment,
            ], 200);
        } catch (Exception $e) {
            Log::error('Comment deleted error: ' . $e->getMessage());
            return response()->json([
                'status'  => false,
                'message' => 'data not found',
            ]);
        }
    }

    public function addOrRemoveCommentReaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment_id' => 'required|numeric|exists:comments,id',
        ]);
        if ($validator->fails()) {
            $firstError = collect($validator->errors()->all())->first();
            return response()->json([
                'message' => $firstError,
                'errors'  => $validator->errors(),
            ], 422);
        }
        $reaction = CommentReaction::where('user_id', Auth::user()->id)->where('comment_id', $request->comment_id)->first();
        if ($reaction) {
            $reaction->delete();
            $status = 'Comment reaction removed';
            $action = 'removed';

        } else {
            $reaction = CommentReaction::create([
                'user_id'    => Auth::id(),
                'comment_id' => $request->comment_id,
            ]);
            $status = 'Comment reaction added';
            $action = 'added';
        }

        $reactionsCount = CommentReaction::where('comment_id', $request->comment_id)->count();

        $comment         = Comment::find($request->comment_id);

        $isReact = CommentReaction::where('comment_id', $request->comment_id)
            ->where('user_id', Auth::id())
            ->exists();

        return response()->json([
            'status'                 => true,
            'message'                => $status,
            'action'                 => $action,
            'reactions_count_format' => Number::abbreviate($reactionsCount),
            'is_react'               => $isReact,
        ], 200);
    }

}
