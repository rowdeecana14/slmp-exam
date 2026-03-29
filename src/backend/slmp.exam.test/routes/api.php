<?php

use App\Http\Controllers\Api\V1\AlbumController;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\PhotoController;
use App\Http\Controllers\Api\V1\PostController;
use App\Http\Controllers\Api\V1\TodoController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('login', [AuthController::class, 'login']);

        Route::middleware('auth:api')->group(function () {
            Route::get('me', [AuthController::class, 'me']);
            Route::post('refresh', [AuthController::class, 'refresh']);
            Route::post('logout', [AuthController::class, 'logout']);
        });
    });

    Route::middleware('auth:api')->group(function () {
        Route::get('posts', [PostController::class, 'index']);
        Route::get('comments', [CommentController::class, 'index']);
        Route::get('albums', [AlbumController::class, 'index']);
        Route::get('photos', [PhotoController::class, 'index']);
        Route::get('todos', [TodoController::class, 'index']);
        Route::get('users', [UserController::class, 'index']);

        Route::get('posts/{post}/comments', [PostController::class, 'comments']);
        Route::get('albums/{album}/photos', [AlbumController::class, 'photos']);
        Route::get('users/{user}/albums', [UserController::class, 'albums']);
        Route::get('users/{user}/todos', [UserController::class, 'todos']);
        Route::get('users/{user}/posts', [UserController::class, 'posts']);
    });
});
