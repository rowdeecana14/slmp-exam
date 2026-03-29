<?php

namespace Tests\Feature\Api;

class TodosApiTest extends ApiTestCase
{
    public function test_authenticated_clients_can_read_todos(): void
    {
        $token = $this->authenticateImportedApiClient();

        $this->authorizedGetJson('/api/v1/todos?page=1', $token)
            ->assertOk()
            ->assertJsonPath('data.0.id', 1)
            ->assertJsonPath('data.0.user.id', 1);
    }
}
