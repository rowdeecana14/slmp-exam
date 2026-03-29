<?php

namespace App\DTO;

readonly class UserDTO
{
    public function __construct(
        public int $id,
        public string $name,
        public string $username,
        public string $email,
        public string $phone,
        public string $website,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: (int) $data['id'],
            name: $data['name'],
            username: $data['username'],
            email: $data['email'],
            phone: $data['phone'],
            website: $data['website'],
        );
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'username' => $this->username,
            'email' => $this->email,
            'phone' => $this->phone,
            'website' => $this->website,
        ];
    }
}
