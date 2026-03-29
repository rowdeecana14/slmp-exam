<?php

namespace App\DTO;

readonly class PostDTO
{
    public function __construct(
        public int $id,
        public int $userId,
        public string $title,
        public string $body,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            userId: (int) $data['userId'],
            title: $data['title'],
            body: $data['body'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'title' => $this->title,
            'body' => $this->body,
        ];
    }
}
