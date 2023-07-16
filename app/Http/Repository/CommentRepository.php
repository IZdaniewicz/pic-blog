<?php

namespace App\Http\Repository;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentCollection;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class CommentRepository
{
    public function findAllForUser(int $id): CommentCollection
    {
        return new CommentCollection(Comment::where('user_id', '=', $id)->get());
    }

    public function create(StoreCommentRequest $request): JsonResponse
    {
        Comment::create($request->all());

        return response()->json([
            'message' => 'Comment created!'
        ]);
    }

    public function update(UpdateCommentRequest $request, int $id): JsonResponse
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id != Auth::user()->id) {
            return response()->json([
                'message' => 'You dont own this comment !'
            ], 403);
        }

        $comment->content = $request['content'];
        $comment->save();

        return response()->json([
            'message' => 'Comment updated!'
        ]);
    }

    public function delete(int $id): JsonResponse
    {
        $comment = Post::findOrFail($id);
        $comment->delete();

        if ($comment->user_id != Auth::user()->id) {
            return response()->json([
                'message' => 'You dont own this comment !'
            ], 403);
        }

        return response()->json([
            'message' => 'Comment deleted!'
        ]);
    }

}
