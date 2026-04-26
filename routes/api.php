<?php

use App\Http\Controllers\AjaxController;
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

// In routes/web.php
Route::prefix('navbar')->group(function () {
    Route::get('/latest', [AjaxController::class, 'getLatestPosts'])->name('navbar.latest');
    Route::get('/category/{slug}', [AjaxController::class, 'getCategoryPosts'])->name('navbar.category');
    Route::get('/switcher/{slug}', [AjaxController::class, 'getCategorySwitcherPosts'])->name('navbar.switcher'); // Fixed
});
