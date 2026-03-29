<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

abstract class BaseJsonResource extends JsonResource
{
    protected function relatedId(string $relation): mixed
    {
        return $this->when(
            $this->relationLoaded($relation) && $this->{$relation} !== null,
            $this->{$relation}?->id,
        );
    }

    protected function whenRelationLoaded(string $relation, string $resource): JsonResource
    {
        return $resource::make($this->whenLoaded($relation));
    }

    protected function whenRelationCollectionLoaded(string $relation, string $resource): AnonymousResourceCollection
    {
        return $resource::collection($this->whenLoaded($relation));
    }
}
