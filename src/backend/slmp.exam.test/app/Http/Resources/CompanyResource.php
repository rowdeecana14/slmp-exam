<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class CompanyResource extends BaseJsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'catch_phrase' => $this->catch_phrase,
            'bs' => $this->bs,
        ];
    }
}
