<?php

namespace App\DTO;

readonly class SyncResultDTO
{
    public function __construct(
        public int $users,
        public int $posts,
        public int $comments,
        public int $albums,
        public int $photos,
        public int $todos,
    ) {}

    public function toArray(): array
    {
        return [
            'users' => $this->users,
            'posts' => $this->posts,
            'comments' => $this->comments,
            'albums' => $this->albums,
            'photos' => $this->photos,
            'todos' => $this->todos,
        ];
    }
}
