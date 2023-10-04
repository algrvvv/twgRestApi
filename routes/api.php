<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;

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

// Route::apiResource('/posts', PostController::class);
Route::apiResource('/posts', PostController::class)->middleware([
    'auth:sanctum', 'abilities:post:update'
])->only('update');

Route::apiResource('/posts', PostController::class)->middleware('auth:sanctum')->except('update');

Route::apiResource('/comments', CommentController::class)->middleware([
    'auth:sanctum', 'abilities:comm:create'
]);

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);
