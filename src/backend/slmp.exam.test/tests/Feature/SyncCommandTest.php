<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\BuildsSourceApiPayload;
use Tests\TestCase;

class SyncCommandTest extends TestCase
{
    use BuildsSourceApiPayload;
    use RefreshDatabase;

    public function test_it_imports_and_updates_data_without_creating_duplicates(): void
    {
        $payload = $this->jsonPayload();

        $this->fakeJson($payload);

        $this->artisan('remote-data:sync')
            ->assertSuccessful();

        $this->assertDatabaseCount('users', 2);
        $this->assertDatabaseCount('addresses', 2);
        $this->assertDatabaseCount('companies', 2);
        $this->assertDatabaseCount('posts', 2);
        $this->assertDatabaseCount('comments', 2);
        $this->assertDatabaseCount('albums', 2);
        $this->assertDatabaseCount('photos', 2);
        $this->assertDatabaseCount('todos', 2);

        $user = User::query()
            ->with(['address', 'company'])
            ->findOrFail(1);

        $this->assertSame('Gwenborough', $user->address?->city);
        $this->assertSame('Romaguera-Crona', $user->company?->name);

        $this->fakeJson($payload);

        $this->artisan('remote-data:sync')
            ->assertSuccessful();

        $this->assertDatabaseCount('posts', 2);

        $post = Post::query()->with('comments')->findOrFail(1);

        $this->assertCount(1, $post->comments);
    }
}
