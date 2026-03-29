<?php

namespace Tests\Feature\Api;

class CommentsApiTest extends ApiTestCase
{
    public function test_authenticated_clients_can_read_comments(): void
    {
        $token = $this->authenticateImportedApiClient();

        $this->authorizedGetJson('/api/v1/comments?page=1', $token)
            ->assertOk()
            ->assertJsonPath('data.0.id', 1)
            ->assertJsonPath('data.0.post_id', 1);
    }
}
