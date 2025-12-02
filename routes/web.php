<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\Curator\DashboardController as CuratorDashboardController;
use App\Http\Controllers\Curator\ChallengeManagementController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\CategoryManagementController;
use App\Http\Controllers\Admin\ModerationController;
use Illuminate\Support\Facades\Route;

// public routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/artworks', [ArtworkController::class, 'index'])->name('artworks.index');

Route::get('/category/{category}', [ArtworkController::class, 'byCategory'])->name('artworks.by-category');
Route::get('/tag/{tag}', [ArtworkController::class, 'byTag'])->name('artworks.by-tag');

Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
Route::get('/challenges/{challenge}', [ChallengeController::class, 'show'])->name('challenges.show');

Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

Route::get('/search', [ArtworkController::class, 'search'])->name('artworks.search');

//auth routes
require __DIR__.'/auth.php';


Route::middleware(['auth'])->get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    
    if ($user->role === 'curator' && $user->status === 'active') {
        return redirect()->route('curator.dashboard');
    }
    
    if ($user->role === 'curator' && $user->status === 'pending') {
        return redirect()->route('curator.pending');
    }
    
    if ($user->status === 'suspended') {
        auth()->logout();
        return redirect()->route('login')->with('error', 'Your account has been suspended.');
    }
    
    return app()->make(MemberDashboardController::class)->index();
})->name('dashboard');


Route::middleware(['auth'])->group(function () {
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/picture', [ProfileController::class, 'updatePicture'])->name('profile.picture');
});

Route::middleware(['auth', 'account.active'])->group(function () {
    
    Route::get('/artworks/create', [ArtworkController::class, 'create'])->name('artworks.create');
    Route::post('/artworks', [ArtworkController::class, 'store'])->name('artworks.store');
    Route::get('/artworks/{artwork}/edit', [ArtworkController::class, 'edit'])->name('artworks.edit');
    Route::put('/artworks/{artwork}', [ArtworkController::class, 'update'])->name('artworks.update');
    Route::delete('/artworks/{artwork}', [ArtworkController::class, 'destroy'])->name('artworks.destroy');
    Route::get('/my-artworks', [ArtworkController::class, 'myArtworks'])->name('artworks.mine');
    
    Route::post('/artworks/{artwork}/like', [LikeController::class, 'store'])->name('artworks.like');
    Route::delete('/artworks/{artwork}/unlike', [LikeController::class, 'destroy'])->name('artworks.unlike');
    Route::post('/artworks/{artwork}/favorite', [FavoriteController::class, 'store'])->name('artworks.favorite');
    Route::delete('/artworks/{artwork}/unfavorite', [FavoriteController::class, 'destroy'])->name('artworks.unfavorite');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    
    Route::post('/artworks/{artwork}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/artworks/{artwork}/report', [ReportController::class, 'reportArtwork'])->name('artworks.report');
    Route::post('/comments/{comment}/report', [ReportController::class, 'reportComment'])->name('comments.report');
    Route::get('/my-reports', [ReportController::class, 'myReports'])->name('reports.mine');
    
    Route::post('/challenges/{challenge}/submit', [ChallengeController::class, 'submit'])->name('challenges.submit');
    Route::get('/my-submissions', [ChallengeController::class, 'mySubmissions'])->name('challenges.my-submissions');
});


Route::get('/artworks/{artwork}', [ArtworkController::class, 'show'])->name('artworks.show');

//curator pending
Route::middleware(['auth'])->get('/curator/pending', function () {
    $user = auth()->user();
    
    if ($user->role !== 'curator') {
        abort(403, 'Unauthorized - Only curators can access this page.');
    }
    
    if ($user->status === 'active') {
        return redirect()->route('curator.dashboard')
            ->with('success', 'Your curator account is now active!');
    }
    
    if ($user->status === 'suspended') {
        auth()->logout();
        return redirect()->route('login')
            ->with('error', 'Your account has been suspended.');
    }
    
    if ($user->status === 'rejected') {
        return view('curator.rejected');
    }
    
    return view('curator.pending');
})->name('curator.pending');

//curator routes
Route::middleware(['auth'])->prefix('curator')->name('curator.')->group(function () {
    Route::get('/dashboard', [CuratorDashboardController::class, 'index'])->name('dashboard');
    Route::get('/my-challenges', [ChallengeManagementController::class, 'myChallenges'])->name('challenges.mine');
    Route::get('/challenges/create', [ChallengeManagementController::class, 'create'])->name('challenges.create');
    Route::post('/challenges', [ChallengeManagementController::class, 'store'])->name('challenges.store');
    Route::get('/challenges/{challenge}/edit', [ChallengeManagementController::class, 'edit'])->name('challenges.edit');
    Route::put('/challenges/{challenge}', [ChallengeManagementController::class, 'update'])->name('challenges.update');
    Route::delete('/challenges/{challenge}', [ChallengeManagementController::class, 'destroy'])->name('challenges.destroy');
    Route::get('/challenges/{challenge}/entries', [ChallengeManagementController::class, 'entries'])->name('challenges.entries');
    Route::patch('/curator/challenges/{challenge}/entries/{entry}/select-winner', [ChallengeManagementController::class, 'selectWinner'])->name('challenges.select-winner');
    Route::patch('/curator/challenges/{challenge}/entries/{entry}/remove-winner', [ChallengeManagementController::class, 'removeWinner'])->name('challenges.remove-winner');
});

//admin routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/statistics', [AdminDashboardController::class, 'statistics'])->name('statistics');
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/suspend', [UserManagementController::class, 'suspend'])->name('users.suspend');
    Route::post('/users/{user}/activate', [UserManagementController::class, 'activate'])->name('users.activate');
    Route::get('/curators/pending', [UserManagementController::class, 'pendingCurators'])->name('curators.pending');
    Route::post('/curators/{user}/approve', [UserManagementController::class, 'approveCurator'])->name('curators.approve');
    Route::post('/curators/{user}/reject', [UserManagementController::class, 'rejectCurator'])->name('curators.reject');
    Route::resource('categories', CategoryManagementController::class);
    Route::get('/moderation', [ModerationController::class, 'index'])->name('moderation.index');
    Route::get('/reports/{report}', [ModerationController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/dismiss', [ModerationController::class, 'dismiss'])->name('reports.dismiss');
    Route::post('/reports/{report}/take-down', [ModerationController::class, 'takeDown'])->name('reports.take-down');
});

//API routes
Route::middleware(['auth'])->prefix('api')->name('api.')->group(function () {
    Route::get('/tags/search', [TagController::class, 'search'])->name('tags.search');
    Route::get('/tags/popular', [TagController::class, 'popular'])->name('tags.popular');
    Route::get('/artworks/{artwork}/stats', [ArtworkController::class, 'stats'])->name('artworks.stats');
});