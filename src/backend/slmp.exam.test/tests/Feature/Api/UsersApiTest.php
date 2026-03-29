<?php

namespace Tests\Feature\Api;

class UsersApiTest extends ApiTestCase
{
    public function test_authenticated_clients_can_read_users(): void
    {
        $token = $this->authenticateImportedApiClient();

        $this->authorizedGetJson('/api/v1/users?page=1', $token)
            ->assertOk()
            ->assertJsonPath('data.0.id', 1)
            ->assertJsonPath('data.0.address.city', 'Gwenborough')
            ->assertJsonPath('data.0.company.name', 'Romaguera-Crona');
    }

    public function test_authenticated_clients_can_read_user_albums(): void
    {
        $token = $this->authenticateImportedApiClient();

        $this->authorizedGetJson('/api/v1/users/1/albums?page=1', $token)
            ->assertOk()
            ->assertJsonPath('data.0.id', 1)
            ->assertJsonPath('data.0.user_id', 1);
    }

    public function test_authenticated_clients_can_read_user_todos(): void
    {
        $token = $this->authenticateImportedApiClient();

        $this->authorizedGetJson('/api/v1/users/1/todos?page=1', $token)
            ->assertOk()
            ->assertJsonPath('data.0.id', 1)
            ->assertJsonPath('data.0.user_id', 1);
    }

    public function test_authenticated_clients_can_read_user_posts(): void
    {
        $token = $this->authenticateImportedApiClient();

        $this->authorizedGetJson('/api/v1/users/1/posts?page=1', $token)
            ->assertOk()
            ->assertJsonPath('data.0.id', 1)
            ->assertJsonPath('data.0.user_id', 1);
    }
}
