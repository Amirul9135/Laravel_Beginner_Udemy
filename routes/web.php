<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'showCorrectHomepage'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout']);

Route::prefix('profile')->group(function () {
    Route::get('/{user}/posts', [UserController::class, 'userPosts']);
    Route::get('/{user}/avatar/manage', [UserController::class, 'manageAvatar']);
    Route::put('/{user}/avatar', [UserController::class, 'updateAvatar']);
});

Route::prefix('api')->group(function () {
    Route::resource('users', UserController::class, [
        'except' => ['create', 'edit'], //seems unnecessary for fully JSON based API services, according to docs both create and edit is path to display forms je. maybe convenient if prerendered via blade but prefer total separation BE/FE
    ]);
    Route::resource('posts', PostController::class, [
        'except' => ['create', 'edit'],
    ]);
});

Route::prefix('view')->group(function () {
    Route::resource('posts', PostController::class, [
        'only' => ['create', 'edit'],
    ])->middleware('auth');
});

Route::get('/token', function () {
    return csrf_token();
});
