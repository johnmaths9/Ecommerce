<?php

use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\ProductController;
use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\User\WishlistController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});




Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
->middleware('auth:sanctum');
Route::post('/register', [RegisteredUserController::class, 'store']);

Route::apiResource('products', AdminProductController::class);
Route::apiResource('categories', AdminCategoryController::class);

Route::get('/test', [RegisteredUserController::class, 'test']);


Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::get('/products/{id}/reviews', [ReviewController::class, 'index']);
    Route::post('/products/{id}/reviews', [ReviewController::class, 'store']);

    Route::get('/cart', [CartController::class, 'index']);
    Route::post('/cart', [CartController::class, 'store']);
    Route::delete('/cart/{productId}', [CartController::class, 'destroy']);
    Route::put('/cart/{productId}', [CartController::class, 'update']);

    Route::get('wishlist', [WishlistController::class, 'index']);
    Route::post('wishlist', [WishlistController::class, 'store']);
    Route::delete('wishlist/{id}', [WishlistController::class, 'destroy']);


    Route::post('/orders', [OrderController::class, 'store']);



});

// user
Route::prefix('user')->group(function () {
    Route::get('products', [ProductController::class, 'index']);
    Route::get('products/{slug}', [ProductController::class, 'show']);


});

