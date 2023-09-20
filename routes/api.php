<?php

use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\FolderController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:sanctum')
    ->get('/user', fn (Request $request) => $request->user());

Route::post('/user/register', [UserController::class, 'register'])
    ->name('register');
Route::post('/user/login', [UserController::class, 'login'])
    ->name('login');

Route::get('/folder/tree', [FolderController::class, 'tree']);

Route::get('/product/{slug}', [ProductController::class, 'show']);
Route::post('/product/filter', [ProductController::class, 'filter']);

Route::get('/cart/{uuid}', [CartController::class, 'show']);
Route::post('/cart', [CartController::class, 'edit']);
Route::delete('/cart', [CartController::class, 'delete']);

Route::get('/order/{uuid}', [OrderController::class, 'show']);
Route::middleware('auth:sanctum')
    ->get('/order', [OrderController::class, 'showAll']);
Route::post('/order', [OrderController::class, 'make']);

Route::middleware('auth:sanctum')->group(function () {
});
