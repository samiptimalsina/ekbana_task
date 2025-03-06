<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\ApiKeyMiddleware;
use App\Http\Controllers\API\CompanyController;
use App\Http\Controllers\API\CompanyCategoryController;
// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware([ApiKeyMiddleware::class])->group(function () {

    Route::get('/category', [CompanyCategoryController::class, 'index']);
    Route::get('/category/{id}', [CompanyCategoryController::class, 'show']);
    Route::post('/category', [CompanyCategoryController::class, 'store']);
    Route::put('/category/{id}', [CompanyCategoryController::class, 'update']);
    Route::delete('/category/{id}', [CompanyCategoryController::class, 'destroy']);
    Route::get('/category', [CompanyCategoryController::class, 'search']);

    Route::get('/company', [CompanyController::class, 'index']);
    Route::get('/company/{id}', [CompanyController::class, 'show']);
    Route::post('/company', [CompanyController::class, 'store']);
    Route::put('/company/{id}', [CompanyController::class, 'update']);
    Route::delete('/company/{id}', [CompanyController::class, 'destroy']);
});
