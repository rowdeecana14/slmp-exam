<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\AlbumResource;
use App\Http\Resources\PhotoResource;
use App\Models\Album;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AlbumController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $limit = (int) $request->query('limit', 10);
        $page = (int) $request->query('page', 1);
        
        $albums = Album::query()
            ->with(['user.address', 'user.company'])
            ->orderBy('id')
            ->paginate($limit, page: $page);

        return AlbumResource::collection($albums);
    }

    public function photos(Request $request, Album $album): AnonymousResourceCollection
    {
        $limit = (int) $request->query('limit', 10);
        $page = (int) $request->query('page', 1);
        
        $photos = $album->photos()
            ->with('album')
            ->orderBy('id')
            ->paginate($limit, page: $page);

        return PhotoResource::collection($photos);
    }
}
