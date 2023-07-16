<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $response = [
            'id' => $this->id,
            'userId' => $this->user_id,
            'title' => $this->title,
            'likesCount' => $this->likes_count,
            'publishDate' => $this->publish_date,
            'commentsCount' => count($this->comments)
        ];

        if ($request->route()->getActionMethod() === 'show') {
            $response['comments'] = CommentResource::collection($this->whenLoaded('comments'));
        }

        return $response;
    }
}
