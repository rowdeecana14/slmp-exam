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
            'id' => $this->id,
            'title' => $this->title,
            'url' => $this->url,
            'thumbnail_url' => $this->thumbnail_url,
            'album_id' => $this->album_id,
        ];
    }
}
