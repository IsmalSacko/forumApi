<?php

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
$controller = \App\Http\Controllers\Auth\AuthController::class;

Route::get('/users', [$controller, 'index'])->name('users_index');
Route::post('/register', [$controller, 'create'])->name('create');
Route::post('/login', [$controller, 'login'])->name('login');
Route::get('/tasks/show/{id}', [$controller, 'show'])->name('show');
Route::delete('/tasks/delete/{id}', [$controller, 'destroy'])->name('destroy');
Route::put('/tasks/update/{id}', [$controller, 'update'])->name('update');
$postController = App\Http\Controllers\Feed\FeedController::class;
Route::get('/posts', [$postController, 'index'])->name('index')->middleware('auth:sanctum');
Route::post('/post', [$postController, 'store'])->name('store')->middleware('auth:sanctum');

Route::post('/post/like/{feedd_id}', [$postController, 'likePost'])->name('likePost')->middleware('auth:sanctum');

Route::post('/post/comment/{feedd_id}', [$postController, 'commentPost'])->name('commentPost')->middleware('auth:sanctum');

Route::get('/post/comments/{feedd_id}', [$postController, 'getComments'])->name('getComments')->middleware('auth:sanctum');
// updateComment
Route::post('/post/comment/update/{comment_id}', [$postController, 'updateComment'])->name('updateComment')->middleware('auth:sanctum');
Route::delete('/post/comment/delete/{comment_id}', [$postController, 'deleteComment'])->name('deleteComment')->middleware('auth:sanctum');
