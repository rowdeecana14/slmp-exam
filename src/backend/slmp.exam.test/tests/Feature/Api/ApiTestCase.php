<?php

namespace Tests\Feature\Api;

use App\Models\AuthUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\Traits\BuildsSourceApiPayload;
use Tests\TestCase;

abstract class ApiTestCase extends TestCase
{
    use BuildsSourceApiPayload;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config(['jwt.secret' => '12345678901234567890123456789012']);
    }

    protected function syncRemoteData(): void
    {
        $this->fakeJson();

        $this->artisan('remote-data:sync')
            ->assertSuccessful();
    }

    protected function createApiUser(): AuthUser
    {
        return AuthUser::factory()->create([
            'name' => 'API Tester',
            'email' => 'api@example.test',
            'password' => 'password',
        ]);
    }

    protected function loginAsApiUser(): TestResponse
    {
        return $this->postJson('/api/v1/auth/login', [
            'email' => 'api@example.test',
            'password' => 'password',
        ]);
    }

    protected function authenticateApiUser(): string
    {
        $this->createApiUser();

        return $this->loginAsApiUser()
            ->assertOk()
            ->json('access_token');
    }

    protected function authenticateImportedApiClient(): string
    {
        $this->syncRemoteData();

        return $this->authenticateApiUser();
    }

    protected function authorizedGetJson(string $uri, string $token): TestResponse
    {
        return $this->withHeader('Authorization', 'Bearer '.$token)
            ->getJson($uri);
    }

    protected function authorizedPostJson(string $uri, string $token): TestResponse
    {
        return $this->withHeader('Authorization', 'Bearer '.$token)
            ->postJson($uri);
    }
}
