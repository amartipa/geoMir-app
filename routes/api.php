<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\FileController;
use App\Http\Controllers\Api\TokenController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\CommentController;
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
Route::apiResource('files', FileController::class);
Route::post('files/{file}', [FileController::class, 'update_workaround']);

//post routes
Route::apiResource('posts', PostController::class)->middleware('auth:sanctum');
Route::post('posts/{post}/likes', [PostController::class, 'like'])->middleware('auth:sanctum');
Route::post('posts/{posts}', [PostController::class, 'update_workaround'])->middleware('auth:sanctum');;

Route::post('posts/{post}/comments', [CommentController::class, 'comment'])->middleware('auth:sanctum');
Route::delete('posts/{post}/uncomment', [CommentController::class, 'unComment'])->middleware('auth:sanctum');

//token routes
Route::get('user', [TokenController::class, 'user'])->middleware('auth:sanctum');
Route::post('register', [TokenController::class, 'register'])->middleware('guest');
Route::post('login', [TokenController::class, 'login'])->middleware('guest');
Route::post('logout', [TokenController::class, 'logout'])->middleware('auth:sanctum');

