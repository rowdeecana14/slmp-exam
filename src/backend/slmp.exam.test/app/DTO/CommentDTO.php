<?php

namespace App\DTO;

readonly class CommentDTO
{
    public function __construct(
        public int $id,
        public int $postId,
        public string $name,
        public string $email,
        public string $body,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            postId: (int) $data['postId'],
            name: $data['name'],
            email: $data['email'],
            body: $data['body'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'post_id' => $this->postId,
            'name' => $this->name,
            'email' => $this->email,
            'body' => $this->body,
        ];
    }
}
