<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $limit = (int) $request->query('limit', 10);
        $page = (int) $request->query('page', 1);
        
        $posts = Post::query()
            ->with(['user.address', 'user.company'])
            ->orderBy('id')
            ->paginate($limit, page: $page);

        return PostResource::collection($posts);
    }

    public function comments(Request $request, Post $post): AnonymousResourceCollection
    {
        $limit = (int) $request->query('limit', 10);
        $page = (int) $request->query('page', 1);
        
        $comments = $post->comments()
            ->with('post')
            ->orderBy('id')
            ->paginate($limit, page: $page);

        return CommentResource::collection($comments);
    }
}
