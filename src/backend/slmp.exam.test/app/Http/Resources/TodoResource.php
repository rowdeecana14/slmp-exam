<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class TodoResource extends BaseJsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'id' => $this->id,
            'title' => $this->title,
            'completed' => $this->completed,
        ];
    }
}
