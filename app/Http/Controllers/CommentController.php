<?php

namespace App\Http\Controllers;

use App\Http\Repository\CommentRepository;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentCollection;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    private CommentRepository $commentRepository;

    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function findAllForUser(int $userId): CommentCollection
    {
        return $this->commentRepository->findAllForUser($userId);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request): JsonResponse
    {
        return $this->commentRepository->create($request);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCommentRequest $request, int $commentId): JsonResponse
    {
        return $this->commentRepository->update($request,$commentId);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $commentId): JsonResponse
    {
        return $this->commentRepository->delete($commentId);
    }
}
