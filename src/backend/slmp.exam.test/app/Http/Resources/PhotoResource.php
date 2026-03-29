<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class PhotoResource extends BaseJsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'album_id' => $this->album_id,
            'id' => $this->id,
            'title' => $this->title,
            'url' => $this->url,
            'thumbnail_url' => $this->thumbnail_url,
        ];
    }
}
