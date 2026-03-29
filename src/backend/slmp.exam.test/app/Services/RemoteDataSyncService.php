<?php

namespace App\Services;

use App\DTO\AddressDTO;
use App\DTO\AlbumDTO;
use App\DTO\CommentDTO;
use App\DTO\CompanyDTO;
use App\DTO\PhotoDTO;
use App\DTO\PostDTO;
use App\DTO\SyncResultDTO;
use App\DTO\TodoDTO;
use App\DTO\UserDTO;
use App\Models\Address;
use App\Models\Album;
use App\Models\Comment;
use App\Models\Company;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Client\Pool;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class RemoteDataSyncService
{
    public function sync(): SyncResultDTO
    {
        $payload = $this->fetchPayload();

        return DB::transaction(function () use ($payload): SyncResultDTO {
            $userCount = $this->syncUsers($payload['users']);
            $this->syncAddresses($payload['users']);
            $this->syncCompanies($payload['users']);
            $postCount = $this->syncPosts($payload['posts']);
            $commentCount = $this->syncComments($payload['comments']);
            $albumCount = $this->syncAlbums($payload['albums']);
            $photoCount = $this->syncPhotos($payload['photos']);
            $todoCount = $this->syncTodos($payload['todos']);

            return new SyncResultDTO(
                users: $userCount,
                posts: $postCount,
                comments: $commentCount,
                albums: $albumCount,
                photos: $photoCount,
                todos: $todoCount,
            );
        });
    }

    /**
     * @return array{
     *     users: array<int, array<string, mixed>>,
     *     posts: array<int, array<string, mixed>>,
     *     comments: array<int, array<string, mixed>>,
     *     albums: array<int, array<string, mixed>>,
     *     photos: array<int, array<string, mixed>>,
     *     todos: array<int, array<string, mixed>>
     * }
     */
    private function fetchPayload(): array
    {
        $baseUrl = rtrim((string) config('services.source_api.base_url'), '/');

        if ($baseUrl === '') {
            throw new RuntimeException('The source API base URL is not configured.');
        }

        $responses = Http::acceptJson()
            ->timeout(20)
            ->pool(fn (Pool $pool) => [
                $pool->as('users')->get($baseUrl.'/users'),
                $pool->as('posts')->get($baseUrl.'/posts'),
                $pool->as('comments')->get($baseUrl.'/comments'),
                $pool->as('albums')->get($baseUrl.'/albums'),
                $pool->as('photos')->get($baseUrl.'/photos'),
                $pool->as('todos')->get($baseUrl.'/todos'),
            ]);

        foreach (['users', 'posts', 'comments', 'albums', 'photos', 'todos'] as $resource) {
            $responses[$resource]->throw();
        }

        return [
            'users' => $responses['users']->json(),
            'posts' => $responses['posts']->json(),
            'comments' => $responses['comments']->json(),
            'albums' => $responses['albums']->json(),
            'photos' => $responses['photos']->json(),
            'todos' => $responses['todos']->json(),
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $users
     */
    private function syncUsers(array $users): int
    {
        $timestamp = now();

        $dtos = array_map(fn (array $user): UserDTO => UserDTO::fromArray($user), $users);

        User::query()->upsert(
            array_map(function (UserDTO $dto) use ($timestamp): array {
                $data = $dto->toArray();
                return array_merge($data, [
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
            }, $dtos),
            ['id'],
            ['name', 'username', 'email', 'phone', 'website', 'updated_at'],
        );

        return count($dtos);
    }

    /**
     * @param  array<int, array<string, mixed>>  $users
     */
    private function syncAddresses(array $users): void
    {
        $timestamp = now();

        $dtos = array_map(fn (array $user): AddressDTO => AddressDTO::fromArray($user), $users);

        Address::query()->upsert(
            array_map(function (AddressDTO $dto) use ($timestamp): array {
                $data = $dto->toArray();
                return array_merge($data, [
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
            }, $dtos),
            ['user_id'],
            ['street', 'suite', 'city', 'zipcode', 'latitude', 'longitude', 'updated_at'],
        );
    }

    /**
     * @param  array<int, array<string, mixed>>  $users
     */
    private function syncCompanies(array $users): void
    {
        $timestamp = now();

        $dtos = array_map(fn (array $user): CompanyDTO => CompanyDTO::fromArray($user), $users);

        Company::query()->upsert(
            array_map(function (CompanyDTO $dto) use ($timestamp): array {
                $data = $dto->toArray();
                return array_merge($data, [
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
            }, $dtos),
            ['user_id'],
            ['name', 'catch_phrase', 'bs', 'updated_at'],
        );
    }

    /**
     * @param  array<int, array<string, mixed>>  $posts
     */
    private function syncPosts(array $posts): int
    {
        $timestamp = now();

        $dtos = array_map(fn (array $post): PostDTO => PostDTO::fromArray($post), $posts);

        Post::query()->upsert(
            array_map(function (PostDTO $dto) use ($timestamp): array {
                $data = $dto->toArray();
                return array_merge($data, [
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
            }, $dtos),
            ['id'],
            ['user_id', 'title', 'body', 'updated_at'],
        );

        return count($dtos);
    }

    /**
     * @param  array<int, array<string, mixed>>  $comments
     */
    private function syncComments(array $comments): int
    {
        $timestamp = now();

        $dtos = array_map(fn (array $comment): CommentDTO => CommentDTO::fromArray($comment), $comments);

        Comment::query()->upsert(
            array_map(function (CommentDTO $dto) use ($timestamp): array {
                $data = $dto->toArray();
                return array_merge($data, [
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
            }, $dtos),
            ['id'],
            ['post_id', 'name', 'email', 'body', 'updated_at'],
        );

        return count($dtos);
    }

    /**
     * @param  array<int, array<string, mixed>>  $albums
     */
    private function syncAlbums(array $albums): int
    {
        $timestamp = now();

        $dtos = array_map(fn (array $album): AlbumDTO => AlbumDTO::fromArray($album), $albums);

        Album::query()->upsert(
            array_map(function (AlbumDTO $dto) use ($timestamp): array {
                $data = $dto->toArray();
                return array_merge($data, [
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
            }, $dtos),
            ['id'],
            ['user_id', 'title', 'updated_at'],
        );

        return count($dtos);
    }

    /**
     * @param  array<int, array<string, mixed>>  $photos
     */
    private function syncPhotos(array $photos): int
    {
        $timestamp = now();

        $dtos = array_map(fn (array $photo): PhotoDTO => PhotoDTO::fromArray($photo), $photos);

        Photo::query()->upsert(
            array_map(function (PhotoDTO $dto) use ($timestamp): array {
                $data = $dto->toArray();
                return array_merge($data, [
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
            }, $dtos),
            ['id'],
            ['album_id', 'title', 'url', 'thumbnail_url', 'updated_at'],
        );

        return count($dtos);
    }

    /**
     * @param  array<int, array<string, mixed>>  $todos
     */
    private function syncTodos(array $todos): int
    {
        $timestamp = now();

        $dtos = array_map(fn (array $todo): TodoDTO => TodoDTO::fromArray($todo), $todos);

        Todo::query()->upsert(
            array_map(function (TodoDTO $dto) use ($timestamp): array {
                $data = $dto->toArray();
                return array_merge($data, [
                    'created_at' => $timestamp,
                    'updated_at' => $timestamp,
                ]);
            }, $dtos),
            ['id'],
            ['user_id', 'title', 'completed', 'updated_at'],
        );

        return count($dtos);
    }
}
