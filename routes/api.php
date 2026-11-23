<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{CategoryController, PostController};


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::name('api.')->group(function () {
    Route::patch('posts/{post}/restore', [PostController::class, 'restore'])
        ->withTrashed()->name('posts.restore');
    Route::apiResource('posts', PostController::class);
    Route::apiResource('categories', CategoryController::class);
});