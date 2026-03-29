<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\PostResource;
use App\Http\Resources\TodoResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $limit = (int) $request->query('limit', 10);
        $page = (int) $request->query('page', 1);
        
        $users = User::query()
            ->with(['address', 'company'])
            ->withCount(['posts', 'albums', 'todos'])
            ->orderBy('id')
            ->paginate($limit, page: $page);

        return UserResource::collection($users);
    }

    public function albums(Request $request, User $user): AnonymousResourceCollection
    {
        $limit = (int) $request->query('limit', 10);
        $page = (int) $request->query('page', 1);
        
        $albums = $user->albums()
            ->with(['user.address', 'user.company'])
            ->orderBy('id')
            ->paginate($limit, page: $page);

        return AlbumResource::collection($albums);
    }

    public function todos(Request $request, User $user): AnonymousResourceCollection
    {
        $limit = (int) $request->query('limit', 10);
        $page = (int) $request->query('page', 1);
        
        $todos = $user->todos()
            ->with(['user.address', 'user.company'])
            ->orderBy('id')
            ->paginate($limit, page: $page);

        return TodoResource::collection($todos);
    }

    public function posts(Request $request, User $user): AnonymousResourceCollection
    {
        $limit = (int) $request->query('limit', 10);
        $page = (int) $request->query('page', 1);
        
        $posts = $user->posts()
            ->with(['user.address', 'user.company'])
            ->orderBy('id')
            ->paginate($limit, page: $page);

        return PostResource::collection($posts);
    }
}
