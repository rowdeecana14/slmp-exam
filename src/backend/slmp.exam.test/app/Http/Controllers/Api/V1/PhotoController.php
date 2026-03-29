<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PhotoResource;
use App\Models\Photo;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PhotoController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $limit = (int) $request->query('limit', 10);
        $page = (int) $request->query('page', 1);
        
        $photos = Photo::query()
            ->with('album')
            ->orderBy('id')
            ->paginate($limit, page: $page);

        return PhotoResource::collection($photos);
    }
}
