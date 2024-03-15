<?php

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', function (Request $request) {
    $data = $request->validate([
        'username' => ['required'],
        'password' => ['required'],
    ]);

    if (auth()->attempt(['username' => $data['username'], 'password' => $data['password']])) {

        /** @var \App\Models\User $user * */
        $user = User::where('username', $data['username'])->first();

        return $user->createToken('somesecret')->plainTextToken;
    } else {

        return redirect('/')->with('error', 'Invalid Login, Please Try Again');
    }
});

Route::get('/test', function () {
    return 'only authorized by token';
})->middleware('auth:sanctum');
