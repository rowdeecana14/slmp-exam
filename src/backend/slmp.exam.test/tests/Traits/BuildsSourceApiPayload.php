<?php

namespace Tests\Traits;

use Illuminate\Support\Facades\Http;

trait BuildsSourceApiPayload
{
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
    protected function jsonPayload(): array
    {
        return [
            'users' => [
                [
                    'id' => 1,
                    'name' => 'Leanne Graham',
                    'username' => 'Bret',
                    'email' => 'leanne@example.test',
                    'address' => [
                        'street' => 'Kulas Light',
                        'suite' => 'Apt. 556',
                        'city' => 'Gwenborough',
                        'zipcode' => '92998-3874',
                        'geo' => [
                            'lat' => '-37.3159',
                            'lng' => '81.1496',
                        ],
                    ],
                    'phone' => '1-770-736-8031 x56442',
                    'website' => 'hildegard.org',
                    'company' => [
                        'name' => 'Romaguera-Crona',
                        'catchPhrase' => 'Multi-layered client-server neural-net',
                        'bs' => 'harness real-time e-markets',
                    ],
                ],
                [
                    'id' => 2,
                    'name' => 'Ervin Howell',
                    'username' => 'Antonette',
                    'email' => 'ervin@example.test',
                    'address' => [
                        'street' => 'Victor Plains',
                        'suite' => 'Suite 879',
                        'city' => 'Wisokyburgh',
                        'zipcode' => '90566-7771',
                        'geo' => [
                            'lat' => '-43.9509',
                            'lng' => '-34.4618',
                        ],
                    ],
                    'phone' => '010-692-6593 x09125',
                    'website' => 'anastasia.net',
                    'company' => [
                        'name' => 'Deckow-Crist',
                        'catchPhrase' => 'Proactive didactic contingency',
                        'bs' => 'synergize scalable supply-chains',
                    ],
                ],
            ],
            'posts' => [
                [
                    'userId' => 1,
                    'id' => 1,
                    'title' => 'sunt aut facere repellat',
                    'body' => 'quia et suscipit suscipit recusandae consequuntur expedita',
                ],
                [
                    'userId' => 2,
                    'id' => 2,
                    'title' => 'qui est esse',
                    'body' => 'est rerum tempore vitae sequi sint nihil reprehenderit',
                ],
            ],
            'comments' => [
                [
                    'postId' => 1,
                    'id' => 1,
                    'name' => 'id labore ex et quam laborum',
                    'email' => 'commenter-one@example.test',
                    'body' => 'laudantium enim quasi est quidem magnam voluptate ipsam eos',
                ],
                [
                    'postId' => 2,
                    'id' => 2,
                    'name' => 'quo vero reiciendis velit similique earum',
                    'email' => 'commenter-two@example.test',
                    'body' => 'est natus enim nihil est dolore omnis voluptatem numquam',
                ],
            ],
            'albums' => [
                [
                    'userId' => 1,
                    'id' => 1,
                    'title' => 'quidem molestiae enim',
                ],
                [
                    'userId' => 2,
                    'id' => 2,
                    'title' => 'sunt qui excepturi placeat culpa',
                ],
            ],
            'photos' => [
                [
                    'albumId' => 1,
                    'id' => 1,
                    'title' => 'accusamus beatae ad facilis cum similique qui sunt',
                    'url' => 'https://example.test/photos/1.jpg',
                    'thumbnailUrl' => 'https://example.test/photos/1-thumb.jpg',
                ],
                [
                    'albumId' => 2,
                    'id' => 2,
                    'title' => 'reprehenderit est deserunt velit ipsam',
                    'url' => 'https://example.test/photos/2.jpg',
                    'thumbnailUrl' => 'https://example.test/photos/2-thumb.jpg',
                ],
            ],
            'todos' => [
                [
                    'userId' => 1,
                    'id' => 1,
                    'title' => 'delectus aut autem',
                    'completed' => false,
                ],
                [
                    'userId' => 2,
                    'id' => 2,
                    'title' => 'quis ut nam facilis et officia qui',
                    'completed' => true,
                ],
            ],
        ];
    }

    /**
     * @param  array{
     *     users: array<int, array<string, mixed>>,
     *     posts: array<int, array<string, mixed>>,
     *     comments: array<int, array<string, mixed>>,
     *     albums: array<int, array<string, mixed>>,
     *     photos: array<int, array<string, mixed>>,
     *     todos: array<int, array<string, mixed>>
     * }|null  $payload
     */
    protected function fakeJson(?array $payload = null): void
    {
        $payload ??= $this->jsonPayload();

        Http::preventStrayRequests();

        Http::fake([
            'https://jsonplaceholder.typicode.com/users' => Http::response($payload['users']),
            'https://jsonplaceholder.typicode.com/posts' => Http::response($payload['posts']),
            'https://jsonplaceholder.typicode.com/comments' => Http::response($payload['comments']),
            'https://jsonplaceholder.typicode.com/albums' => Http::response($payload['albums']),
            'https://jsonplaceholder.typicode.com/photos' => Http::response($payload['photos']),
            'https://jsonplaceholder.typicode.com/todos' => Http::response($payload['todos']),
        ]);
    }
}
