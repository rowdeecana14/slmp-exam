<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class UserResource extends BaseJsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'website' => $this->website,
            'address' => $this->whenRelationLoaded('address', AddressResource::class),
            'company' => $this->whenRelationLoaded('company', CompanyResource::class),
            'posts_count' => $this->whenCounted('posts'),
            'albums_count' => $this->whenCounted('albums'),
            'todos_count' => $this->whenCounted('todos'),
        ];
    }
}
