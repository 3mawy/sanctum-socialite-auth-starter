<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Auth\SocialAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//Route::post('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('login/{provider}', [SocialAuthController::class, 'redirectToProvider']);
Route::get('login/{provider}/callback', [SocialAuthController::class, 'handleProviderCallback']);
