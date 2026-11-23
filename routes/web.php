<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{CategoryController, CommentController, PostController};
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');

Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('/submissions', [ContactController::class, 'index'])->name('submissions.index');
Route::get('posts/trash', [PostController::class, 'trash'])->name('posts.trash');
Route::patch('posts/{post}/restore', [PostController::class, 'restore'])
    ->withTrashed()->name('posts.restore');
Route::delete('posts/{post}/force', [PostController::class, 'forceDelete'])
    ->withTrashed()->name('posts.force-delete');

Route::resource('posts', PostController::class);

Route::resource('categories', CategoryController::class)->only(['index', 'show']);

// полиморфные комментарии
Route::post('posts/{post}/comments', [CommentController::class, 'storeForPost'])
    ->name('posts.comments.store');
Route::post('categories/{category}/comments', [CommentController::class, 'storeForCategory'])
    ->name('categories.comments.store');