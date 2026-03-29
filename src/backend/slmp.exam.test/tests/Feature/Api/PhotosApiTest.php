<?php

namespace Tests\Feature\Api;

class PhotosApiTest extends ApiTestCase
{
    public function test_authenticated_clients_can_read_photos(): void
    {
        $token = $this->authenticateImportedApiClient();

        $this->authorizedGetJson('/api/v1/photos?page=1', $token)
            ->assertOk()
            ->assertJsonPath('data.0.id', 1)
            ->assertJsonPath('data.0.album_id', 1);
    }
}
