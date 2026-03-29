<?php

namespace App\DTO;

readonly class AddressDTO
{
    public function __construct(
        public int $userId,
        public string $street,
        public string $suite,
        public string $city,
        public string $zipcode,
        public string $latitude,
        public string $longitude,
    ) {}

    public static function fromArray(array $user): self
    {
        $address = $user['address'];
        $geo = $address['geo'];

        return new self(
            userId: (int) $user['id'],
            street: $address['street'],
            suite: $address['suite'],
            city: $address['city'],
            zipcode: $address['zipcode'],
            latitude: (string) $geo['lat'],
            longitude: (string) $geo['lng'],
        );
    }

    public function toArray(): array
    {
        return [
            'user_id' => $this->userId,
            'street' => $this->street,
            'suite' => $this->suite,
            'city' => $this->city,
            'zipcode' => $this->zipcode,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
