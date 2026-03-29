<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class CommentResource extends BaseJsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'post_id' => $this->post_id,
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'body' => $this->body,
        ];
    }
}
