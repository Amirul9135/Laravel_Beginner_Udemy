<?php

use App\Events\ChatMessage;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [UserController::class, 'showCorrectHomepage'])->name('login');
Route::post('/login', [UserController::class, 'login']);
Route::post('logout', [UserController::class, 'logout']);

Route::prefix('profile')->group(function () {
    Route::get('/{user:username}/posts', [UserController::class, 'userPosts']);
    Route::get('/{user:username}/avatar/manage', [UserController::class, 'manageAvatar']);
    Route::put('/{user:username}/avatar', [UserController::class, 'updateAvatar']);

    Route::get('/{user:username}/followers', [UserController::class, 'userFollowers']);
    Route::get('/{user:username}/followings', [UserController::class, 'userFollowings']);
});

Route::prefix('api')->group(function () {
    Route::resource('users', UserController::class, [
        'except' => ['create', 'edit'], //seems unnecessary for fully JSON based API services, according to docs both create and edit is path to display forms je. maybe convenient if prerendered via blade but prefer total separation BE/FE
    ]);
    Route::resource('posts', PostController::class, [
        'except' => ['create', 'edit'],
    ]);
    Route::get('posts/find/{term}', [PostController::class, 'search']);
    Route::post('follows/{user}', [FollowController::class, 'createFollow']);
    Route::delete('follows/{user}', [FollowController::class, 'unfollow']);
})->middleware('auth');

Route::prefix('view')->group(function () {
    Route::resource('posts', PostController::class, [
        'only' => ['create', 'edit'],
    ])->middleware('auth');
    /*Route::resource('follows', FollowController::class, [
        'only' => ['create', 'edit'],
    ]);*/
})->middleware('auth');

Route::get('/token', function () {
    return csrf_token();
});

Route::prefix('chat')->group(function () {
    Route::post('/', function (Request $request) {
        try {
            $input = $request->validate([
                'textvalue' => 'required',
            ]);

            $text = trim(strip_tags($input['textvalue']));
            if ($text) {
                broadcast(new ChatMessage(['user' => auth()->user(), 'textvalue' => $text]))->toOthers();
            }

        } catch (Exception $e) {
            dd($e);
        }

        return response()->noContent();
    });
});
