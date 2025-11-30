<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ArtworkController;
use App\Http\Controllers\CategoryController;
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


Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/artworks', [ArtworkController::class, 'index'])->name('artworks.index');
Route::middleware(['auth', 'account.active', 'role:member,curator'])->get('/artworks/create', [ArtworkController::class, 'create'])->name('artworks.create');
Route::get('/artworks/{artwork}', [ArtworkController::class, 'show'])->name('artworks.show');
Route::middleware(['auth', 'account.active', 'role:member,curator'])->get('/artworks/{artwork}/edit', [ArtworkController::class, 'edit'])->name('artworks.edit');

Route::get('/category/{category:slug}', [ArtworkController::class, 'byCategory'])->name('artworks.by-category');

Route::get('/tag/{tag:slug}', [ArtworkController::class, 'byTag'])->name('artworks.by-tag');

Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
Route::get('/challenges/{challenge}', [ChallengeController::class, 'show'])->name('challenges.show');

Route::get('/profile/{user:id}', [ProfileController::class, 'show'])->name('profile.show');

Route::get('/search', [ArtworkController::class, 'search'])->name('artworks.search');

require __DIR__.'/auth.php';

Route::middleware(['auth', 'account.active', 'role:member,curator'])->group(function () {

    Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/picture', [ProfileController::class, 'updatePicture'])->name('profile.picture');

    Route::post('/artworks', [ArtworkController::class, 'store'])->name('artworks.store');
    Route::put('/artworks/{artwork}', [ArtworkController::class, 'update'])->name('artworks.update');
    Route::patch('/artworks/{artwork}', [ArtworkController::class, 'update']);
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

// ✅ CURATOR PENDING PAGE (KHUSUS UNTUK CURATOR PENDING)
// Harus di atas curator.active middleware agar tidak tertimpa
Route::middleware(['auth'])->group(function () {
    Route::get('/curator/pending', function () {
        $user = auth()->user();
        
        // Only curators can access this page
        if ($user->role !== 'curator') {
            abort(403, 'Unauthorized - Only curators can access this page.');
        }
        
        // If suspended, logout immediately
        if ($user->status === 'suspended') {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Your account has been suspended.');
        }
        
        // If already active, redirect to curator dashboard
        if ($user->status === 'active') {
            return redirect()->route('curator.dashboard');
        }
        
        // If rejected, redirect to member dashboard
        if ($user->status === 'rejected') {
            return redirect()->route('dashboard')
                ->with('error', 'Your curator application was rejected.');
        }
        
        // Show pending page for pending curators
        return view('curator.pending');
    })->name('curator.pending');
});

// ✅ CURATOR ACTIVE ROUTES (HANYA UNTUK CURATOR ACTIVE)
Route::middleware(['auth', 'curator.active'])->prefix('curator')->name('curator.')->group(function () {

    Route::get('/dashboard', [CuratorDashboardController::class, 'index'])->name('dashboard');

    Route::resource('challenges', ChallengeManagementController::class)->except(['index', 'show']);
    Route::get('/my-challenges', [ChallengeManagementController::class, 'myChallenges'])->name('challenges.mine');
    Route::get('/challenges/{challenge}/entries', [ChallengeManagementController::class, 'entries'])->name('challenges.entries');
    Route::post('/challenges/{challenge}/select-winner/{entry}', [ChallengeManagementController::class, 'selectWinner'])->name('challenges.select-winner');
    Route::delete('/challenges/{challenge}/remove-winner/{entry}', [ChallengeManagementController::class, 'removeWinner'])->name('challenges.remove-winner');
});

// ✅ ADMIN ROUTES (HANYA UNTUK ADMIN)
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/suspend', [UserManagementController::class, 'suspend'])->name('users.suspend');
    Route::post('/users/{user}/activate', [UserManagementController::class, 'activate'])->name('users.activate');

    // Curator Management
    Route::get('/curators/pending', [UserManagementController::class, 'pendingCurators'])->name('curators.pending');
    Route::post('/curators/{user}/approve', [UserManagementController::class, 'approveCurator'])->name('curators.approve');
    Route::post('/curators/{user}/reject', [UserManagementController::class, 'rejectCurator'])->name('curators.reject');

    // Category Management
    Route::resource('categories', CategoryManagementController::class);

    // Moderation
    Route::get('/moderation', [ModerationController::class, 'index'])->name('moderation.index');
    Route::get('/reports/{report}', [ModerationController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/dismiss', [ModerationController::class, 'dismiss'])->name('reports.dismiss');
    Route::post('/reports/{report}/take-down', [ModerationController::class, 'takeDown'])->name('reports.take-down');

    // Statistics
    Route::get('/statistics', [AdminDashboardController::class, 'statistics'])->name('statistics');
});

Route::middleware(['auth', 'account.active'])->prefix('api')->name('api.')->group(function () {

    Route::get('/tags/search', [TagController::class, 'search'])->name('tags.search');
    Route::get('/tags/popular', [TagController::class, 'popular'])->name('tags.popular');
    Route::get('/artworks/{artwork}/stats', [ArtworkController::class, 'stats'])->name('artworks.stats');
});