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
            'address' => $this->whenRelationLoaded('address', AddressResource::class),
            'phone' => $this->phone,
            'website' => $this->website,
            'company' => $this->whenRelationLoaded('company', CompanyResource::class),
        ];
    }
}
