<?php

namespace Tests\Feature\Api;

class PostsApiTest extends ApiTestCase
{
    public function test_authenticated_clients_can_read_posts(): void
    {
        $token = $this->authenticateImportedApiClient();

        $this->authorizedGetJson('/api/v1/posts?page=1', $token)
            ->assertOk()
            ->assertJsonPath('data.0.id', 1)
            ->assertJsonPath('data.0.user.id', 1);
    }

    public function test_authenticated_clients_can_read_post_comments(): void
    {
        $token = $this->authenticateImportedApiClient();

        $this->authorizedGetJson('/api/v1/posts/1/comments?page=1', $token)
            ->assertOk()
            ->assertJsonPath('data.0.id', 1)
            ->assertJsonPath('data.0.post_id', 1);
    }
}
