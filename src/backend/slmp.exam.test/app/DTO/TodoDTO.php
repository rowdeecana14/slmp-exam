<?php

namespace App\DTO;

readonly class TodoDTO
{
    public function __construct(
        public int $id,
        public int $userId,
        public string $title,
        public bool $completed,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            userId: (int) $data['userId'],
            title: $data['title'],
            completed: (bool) $data['completed'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->userId,
            'title' => $this->title,
            'completed' => $this->completed,
        ];
    }
}
