<?php

namespace App\Http\Repository;

use App\Http\Filters\PostFilter;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PostRepository
{


    public function findAll(): PostCollection
    {
        $filter = new PostFilter();
        $queryItems = $filter->transform(request());

        return new PostCollection(Post::where($queryItems)->paginate(8));
    }


    public function findOne(int $postId): PostResource
    {
        $post = Post::findOrFail($postId);
        return new PostResource($post);
    }

    public function findByTag(string $tagName): PostCollection
    {
        $tag = Tag::where('name',$tagName)->first();
//        dd($tag);

        return new PostCollection($tag->posts);
    }

    public function create(StorePostRequest $request): JsonResponse
    {
        $postData = $request->validated();
        $tags = $request->input('tags', []);

        $postData['user_id'] = Auth::user()->id; // Set the user_id

        $post = Post::create($postData);

        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            $post->tags()->attach($tag->id);
        }

        return response()->json([
            'message' => 'Post created!',
        ]);
    }

    public function update(UpdatePostRequest $request, int $id): JsonResponse
    {
        $post = Post::findOrFail($id);

        if ($post->user_id != Auth::user()->id) {
            return response()->json([
                'message' => 'You dont own this comment !'
            ], 403);
        }

        $post->title = $request['title'];
        $post->save();

        return response()->json([
            'message' => 'Post updated!'
        ]);
    }

    public function delete(int $id): JsonResponse
    {
        $post = Post::findOrFail($id);

        if ($post->user_id != Auth::user()->id) {
            return response()->json([
                'message' => 'You dont own this comment !'
            ], 403);
        }

        $post->delete();

        return response()->json([
            'message' => 'Post deleted!'
        ]);
    }

}
