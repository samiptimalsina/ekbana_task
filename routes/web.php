<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{blog}/crawl', [BlogController::class, 'crawl'])->name('blog.crawl');


Route::resource('blog-sources', \App\Http\Controllers\BlogSourceController::class);
Route::post('blog-sources/{blogSource}/crawl', [\App\Http\Controllers\BlogSourceController::class, 'crawl'])
     ->name('blog-sources.crawl');