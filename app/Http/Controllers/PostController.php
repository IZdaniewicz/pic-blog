<?php

namespace App\Http\Controllers;

use App\Http\Repository\PostRepository;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    private readonly PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }


    /**
     * Display a listing of the resource.
     */
    public function index(): PostCollection
    {
        return $this->postRepository->findAll();
    }

    public function getByTag(string $tagName): PostCollection
    {
        return $this->postRepository->findByTag($tagName);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request): JsonResponse
    {
        return $this->postRepository->create($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): PostResource
    {

        return $this->postRepository->findOne($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, int $id): JsonResponse
    {
        return $this->postRepository->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        return $this->postRepository->delete($id);
    }
}
