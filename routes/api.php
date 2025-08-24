<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;

// Public routes outside the sanctum because new users will not have the token to get validated
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/posts', [PostController::class, 'index']);   //show all posts
    Route::get('/posts/{post}', [PostController::class, 'show']); // show specific post
    Route::post('/posts', [PostController::class, 'store']);      // create post
    Route::put('/posts/{post}', [PostController::class, 'update']); // update post
    Route::delete('/posts/{post}', [PostController::class, 'destroy']); // delete post
    Route::get('/user', function (Request $request) {
        return $request->user();
        
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});
