<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CustomStyleController;
use App\Http\Controllers\Api\ProductImageController;
use App\Http\Controllers\Api\CategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::name('api.')->group(function () {
    Route::apiResource('stores', StoreController::class);
    Route::apiResource('products', ProductController::class);
    Route::apiResource('custom-styles', CustomStyleController::class);
    Route::apiResource('categories', CategoryController::class);
    Route::post(
        '/products/{product}/images/reorder',
        [ProductImageController::class, 'reorder']
    )->name('products.images.reorder');

    Route::delete(
        '/products/images/{image}',
        [ProductImageController::class, 'destroy']
    )->name('products.images.destroy');


});