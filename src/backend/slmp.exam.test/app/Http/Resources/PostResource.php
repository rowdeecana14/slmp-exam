<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PostResource extends BaseJsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'user_id' => $this->user_id,
            'user' => UserResource::make($this->whenLoaded('user')),
            'comments' => $this->whenRelationCollectionLoaded('comments', CommentResource::class),
        ];
    }
}
