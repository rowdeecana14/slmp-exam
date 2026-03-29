<?php

namespace App\DTO;

readonly class CompanyDTO
{
    public function __construct(
        public int $userId,
        public string $name,
        public string $catchPhrase,
        public string $bs,
    ) {}

    public static function fromArray(array $user): self
    {
        $company = $user['company'];

        return new self(
            userId: (int) $user['id'],
            name: $company['name'],
            catchPhrase: $company['catchPhrase'],
            bs: $company['bs'],
        );
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'name' => $this->name,
            'catch_phrase' => $this->catchPhrase,
            'bs' => $this->bs,
        ];
    }
}
