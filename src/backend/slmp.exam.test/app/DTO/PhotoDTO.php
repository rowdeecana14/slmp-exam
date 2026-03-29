<?php

namespace App\DTO;

readonly class PhotoDTO
{
    public function __construct(
        public int $id,
        public int $albumId,
        public string $title,
        public string $url,
        public string $thumbnailUrl,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            albumId: (int) $data['albumId'],
            title: $data['title'],
            url: $data['url'],
            thumbnailUrl: $data['thumbnailUrl'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'album_id' => $this->albumId,
            'title' => $this->title,
            'url' => $this->url,
            'thumbnail_url' => $this->thumbnailUrl,
        ];
    }
}
