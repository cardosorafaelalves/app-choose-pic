<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PhotographersController;
use App\Http\Controllers\PhotographerConfigController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerConfigController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderImageController;
use App\Http\Controllers\UploadController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Photographer CRUD routes
Route::get('photographers', [PhotographersController::class, 'index']); // List all photographers
Route::post('photographers', [PhotographersController::class, 'store']); // Create photographer
Route::get('photographers/{uuid}', [PhotographersController::class, 'show']); // Get photographer by uuid
Route::put('photographers/{uuid}', [PhotographersController::class, 'update']); // Update photographer
Route::delete('photographers/{uuid}', [PhotographersController::class, 'destroy']); // Delete photographer

// PhotographerConfig CRUD routes
Route::get('photographer-configs', [PhotographerConfigController::class, 'index']);
Route::post('photographer-configs', [PhotographerConfigController::class, 'store']);
Route::get('photographer-configs/{uuid}', [PhotographerConfigController::class, 'show']);
Route::put('photographer-configs/{uuid}', [PhotographerConfigController::class, 'update']);
Route::delete('photographer-configs/{uuid}', [PhotographerConfigController::class, 'destroy']);

// Customer CRUD routes
Route::get('customers', [CustomerController::class, 'index']);
Route::post('customers', [CustomerController::class, 'store']);
Route::get('customers/{uuid}', [CustomerController::class, 'show']);
Route::put('customers/{uuid}', [CustomerController::class, 'update']);
Route::delete('customers/{uuid}', [CustomerController::class, 'destroy']);

// CustomerConfig CRUD routes
Route::get('customer-configs', [CustomerConfigController::class, 'index']);
Route::post('customer-configs', [CustomerConfigController::class, 'store']);
Route::get('customer-configs/{uuid}', [CustomerConfigController::class, 'show']);
Route::put('customer-configs/{uuid}', [CustomerConfigController::class, 'update']);
Route::delete('customer-configs/{uuid}', [CustomerConfigController::class, 'destroy']);

// Image CRUD routes
Route::get('images', [ImageController::class, 'index']);
Route::post('images', [ImageController::class, 'store']);
Route::get('images/{uuid}', [ImageController::class, 'show']);
Route::put('images/{uuid}', [ImageController::class, 'update']);
Route::delete('images/{uuid}', [ImageController::class, 'destroy']);

// Order CRUD routes
Route::get('orders', [OrderController::class, 'index']);
Route::post('orders', [OrderController::class, 'store']);
Route::get('orders/{uuid}', [OrderController::class, 'show']);
Route::put('orders/{uuid}', [OrderController::class, 'update']);
Route::delete('orders/{uuid}', [OrderController::class, 'destroy']);

// OrderImage CRUD routes
Route::get('order-images', [OrderImageController::class, 'index']);
Route::post('order-images', [OrderImageController::class, 'store']);
Route::get('order-images/{uuid}', [OrderImageController::class, 'show']);
Route::put('order-images/{uuid}', [OrderImageController::class, 'update']);
Route::delete('order-images/{uuid}', [OrderImageController::class, 'destroy']);

// File upload
Route::post('upload/generateUploadUrl/{cloudService}', [UploadController::class, 'generateUploadUrl']);



