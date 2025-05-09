<?php
declare(strict_types=1);

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserRecommendationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/users/{userId}', [UserController::class, 'show'])->name('users.show');
Route::get('/users/{userId}/recommendations', [UserRecommendationController::class, 'show'])->name('user-recommendations.show');
