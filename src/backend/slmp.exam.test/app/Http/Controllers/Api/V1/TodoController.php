<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\TodoResource;
use App\Models\Todo;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TodoController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $limit = (int) $request->query('limit', 10);
        $page = (int) $request->query('page', 1);
        
        $todos = Todo::query()
            ->with(['user.address', 'user.company'])
            ->orderBy('id')
            ->paginate($limit, page: $page);

        return TodoResource::collection($todos);
    }
}
