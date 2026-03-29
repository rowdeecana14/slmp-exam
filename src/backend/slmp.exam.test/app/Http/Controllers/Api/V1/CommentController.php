<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CommentController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $limit = (int) $request->query('limit', 10);
        $page = (int) $request->query('page', 1);
        
        $comments = Comment::query()
            ->with('post')
            ->orderBy('id')
            ->paginate($limit, page: $page);

        return CommentResource::collection($comments);
    }
}
