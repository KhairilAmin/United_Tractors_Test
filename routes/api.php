<?php
 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'category-products'
],function ($router) {
    Route::post('/', [CategoryController::class, 'store'])->middleware('auth:api')->name('store-category');
    Route::get('/', [CategoryController::class, 'index'])->middleware('auth:api')->name('getall-category');
    Route::post('/{id}', [CategoryController::class, 'update'])->middleware('auth:api')->name('update-category');
    Route::get('/{id}', [CategoryController::class, 'show'])->middleware('auth:api')->name('get-category-byid');
    Route::delete('/{id}', [CategoryController::class, 'delete'])->middleware('auth:api')->name('delete-category');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'products'
],function($router) {
    Route::post('/', [ProductController::class, 'store'])->middleware('auth:api')->name('store-product');
    Route::get('/', [ProductController::class, 'index'])->middleware('auth:api')->name('get-all-product');
    Route::get('/{id}', [ProductController::class, 'show'])->middleware('auth:api')->name('get-byid-product');
    Route::post('/{id}', [ProductController::class, 'update'])->middleware('auth:api')->name('update-product');
    Route::delete('/{id}', [ProductController::class, 'delete'])->middleware('auth:api')->name('delete-product');
});