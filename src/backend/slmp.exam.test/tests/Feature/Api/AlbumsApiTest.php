<?php

namespace Tests\Feature\Api;

class AlbumsApiTest extends ApiTestCase
{
    public function test_authenticated_clients_can_read_albums(): void
    {
        $token = $this->authenticateImportedApiClient();

        $this->authorizedGetJson('/api/v1/albums?page=1', $token)
            ->assertOk()
            ->assertJsonPath('data.0.id', 1)
            ->assertJsonPath('data.0.user.id', 1);
    }

    public function test_authenticated_clients_can_read_album_photos(): void
    {
        $token = $this->authenticateImportedApiClient();

        $this->authorizedGetJson('/api/v1/albums/1/photos?page=1', $token)
            ->assertOk()
            ->assertJsonPath('data.0.id', 1)
            ->assertJsonPath('data.0.album_id', 1);
    }
}
