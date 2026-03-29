<?php

namespace Tests\Feature\Api;

class AuthApiTest extends ApiTestCase
{
    public function test_data_endpoints_require_authentication(): void
    {
        $this->getJson('/api/v1/users')
            ->assertUnauthorized();
    }

    public function test_authenticated_clients_can_log_in_and_read_current_user(): void
    {
        $this->createApiUser();

        $loginResponse = $this->loginAsApiUser();

        $loginResponse
            ->assertOk()
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
                'user' => ['id', 'name', 'email'],
            ]);

        $token = $loginResponse->json('access_token');

        $this->authorizedGetJson('/api/v1/auth/me', $token)
            ->assertOk()
            ->assertJsonPath('data.email', 'api@example.test');
    }

    public function test_authenticated_clients_can_refresh_and_log_out(): void
    {
        $token = $this->authenticateApiUser();

        $refreshResponse = $this->authorizedPostJson('/api/v1/auth/refresh', $token);

        $refreshResponse
            ->assertOk()
            ->assertJsonStructure([
                'access_token',
                'token_type',
                'expires_in',
                'user' => ['id', 'name', 'email'],
            ]);

        $refreshedToken = $refreshResponse->json('access_token');

        $this->authorizedPostJson('/api/v1/auth/logout', $refreshedToken)
            ->assertOk()
            ->assertJsonPath('message', 'Successfully logged out.');
    }
}
