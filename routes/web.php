<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Admin\ModerationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/category/{id}', [HomeController::class, 'filterByCategory'])->name('category.filter');
Route::get('/artworks/{id}', [ArtworkController::class, 'show'])->name('artworks.show');
Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
Route::get('/challenges/{id}', [ChallengeController::class, 'show'])->name('challenges.show');

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/artworks/create', [ArtworkController::class, 'create'])->name('artworks.create');
    Route::post('/artworks', [ArtworkController::class, 'store'])->name('artworks.store');
    Route::get('/artworks/{id}/edit', [ArtworkController::class, 'edit'])->name('artworks.edit');
    Route::put('/artworks/{id}', [ArtworkController::class, 'update'])->name('artworks.update');
    Route::delete('/artworks/{id}', [ArtworkController::class, 'destroy'])->name('artworks.destroy');

    Route::post('/artworks/{id}/like', [LikeController::class, 'toggle'])->name('artworks.like');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/artworks/{id}/favorite', [FavoriteController::class, 'toggle'])->name('artworks.favorite');

    Route::post('/artworks/{id}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::get('/artworks/{id}/report', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/artworks/{id}/report', [ReportController::class, 'store'])->name('reports.store');

    Route::post('/challenges/{id}/submit', [ChallengeController::class, 'submit'])->name('challenges.submit');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/challenges/create', [ChallengeController::class, 'create'])->name('challenges.create');
    Route::post('/challenges', [ChallengeController::class, 'store'])->name('challenges.store');
});

Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    
    Route::get('/dashboard', [ModerationController::class, 'index'])->name('dashboard');

    Route::get('/reports', [ModerationController::class, 'reports'])->name('reports');
    Route::post('/reports/{id}/review', [ModerationController::class, 'reviewReport'])->name('reports.review');

    Route::get('/challenges', [ModerationController::class, 'challenges'])->name('challenges');
    Route::post('/challenges/{id}/review', [ModerationController::class, 'reviewChallenge'])->name('challenges.review');

    Route::get('/users', [ModerationController::class, 'users'])->name('users');
    Route::delete('/users/{id}', [ModerationController::class, 'deleteUser'])->name('users.delete');

    Route::get('/categories', [ModerationController::class, 'categories'])->name('categories');
    Route::post('/categories', [ModerationController::class, 'addCategory'])->name('categories.add');
    Route::delete('/categories/{id}', [ModerationController::class, 'deleteCategory'])->name('categories.delete');
});

require __DIR__.'/auth.php';