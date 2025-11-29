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


// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');

// Browse Artworks
Route::get('/artworks', [ArtworkController::class, 'index'])->name('artworks.index');
Route::get('/artworks/{artwork}', [ArtworkController::class, 'show'])->name('artworks.show');

// Filter by Category
Route::get('/category/{category:slug}', [ArtworkController::class, 'byCategory'])->name('artworks.by-category');

// Filter by Tag
Route::get('/tag/{tag:slug}', [ArtworkController::class, 'byTag'])->name('artworks.by-tag');

// Browse Challenges
Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges.index');
Route::get('/challenges/{challenge}', [ChallengeController::class, 'show'])->name('challenges.show');

// User Profiles (Public)
Route::get('/profile/{user:id}', [ProfileController::class, 'show'])->name('profile.show');

// Search
Route::get('/search', [ArtworkController::class, 'search'])->name('artworks.search');


require __DIR__.'/auth.php';


Route::middleware(['auth', 'account.active', 'role:member,curator'])->group(function () {
    
    // Member Dashboard
    Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');
    
    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/picture', [ProfileController::class, 'updatePicture'])->name('profile.picture');
    
    // Artwork Management
    Route::resource('artworks', ArtworkController::class)->except(['index', 'show']);
    Route::get('/my-artworks', [ArtworkController::class, 'myArtworks'])->name('artworks.mine');
    
    // Interactions
    Route::post('/artworks/{artwork}/like', [LikeController::class, 'store'])->name('artworks.like');
    Route::delete('/artworks/{artwork}/unlike', [LikeController::class, 'destroy'])->name('artworks.unlike');
    
    Route::post('/artworks/{artwork}/favorite', [FavoriteController::class, 'store'])->name('artworks.favorite');
    Route::delete('/artworks/{artwork}/unfavorite', [FavoriteController::class, 'destroy'])->name('artworks.unfavorite');
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    
    // Comments
    Route::post('/artworks/{artwork}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    
    // Reports
    Route::post('/artworks/{artwork}/report', [ReportController::class, 'reportArtwork'])->name('artworks.report');
    Route::post('/comments/{comment}/report', [ReportController::class, 'reportComment'])->name('comments.report');
    Route::get('/my-reports', [ReportController::class, 'myReports'])->name('reports.mine');
    
    // Challenge Submissions
    Route::post('/challenges/{challenge}/submit', [ChallengeController::class, 'submit'])->name('challenges.submit');
    Route::get('/my-submissions', [ChallengeController::class, 'mySubmissions'])->name('challenges.my-submissions');
});

// Temporary debug route: show profile edit page for any authenticated user
// (bypasses the role middleware so you can verify the edit form renders)
Route::middleware(['auth'])->get('/profile/debug-edit', [ProfileController::class, 'edit'])->name('profile.debug-edit');

Route::middleware(['auth', 'curator.active'])->prefix('curator')->name('curator.')->group(function () {
    
    // Curator Dashboard
    Route::get('/dashboard', [CuratorDashboardController::class, 'index'])->name('dashboard');
    
    // Challenge Management
    Route::resource('challenges', ChallengeManagementController::class)->except(['index', 'show']);
    Route::get('/my-challenges', [ChallengeManagementController::class, 'myChallenges'])->name('challenges.mine');
    Route::get('/challenges/{challenge}/entries', [ChallengeManagementController::class, 'entries'])->name('challenges.entries');
    Route::post('/challenges/{challenge}/select-winner/{entry}', [ChallengeManagementController::class, 'selectWinner'])->name('challenges.select-winner');
    Route::delete('/challenges/{challenge}/remove-winner/{entry}', [ChallengeManagementController::class, 'removeWinner'])->name('challenges.remove-winner');
});

// Pending Curator Page
Route::middleware(['auth', 'role:curator'])->group(function () {
    Route::get('/curator/pending', function () {
        if (auth()->user()->isActive()) {
            return redirect()->route('curator.dashboard');
        }
        return view('curator.pending');
    })->name('curator.pending');
});


Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // User Management
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/suspend', [UserManagementController::class, 'suspend'])->name('users.suspend');
    Route::post('/users/{user}/activate', [UserManagementController::class, 'activate'])->name('users.activate');
    
    // Curator Approval
    Route::get('/curators/pending', [UserManagementController::class, 'pendingCurators'])->name('curators.pending');
    Route::post('/curators/{user}/approve', [UserManagementController::class, 'approveCurator'])->name('curators.approve');
    Route::post('/curators/{user}/reject', [UserManagementController::class, 'rejectCurator'])->name('curators.reject');
    
    // Category Management
    Route::resource('categories', CategoryManagementController::class);
    
    // Moderation Queue
    Route::get('/moderation', [ModerationController::class, 'index'])->name('moderation.index');
    Route::get('/reports/{report}', [ModerationController::class, 'show'])->name('reports.show');
    Route::post('/reports/{report}/dismiss', [ModerationController::class, 'dismiss'])->name('reports.dismiss');
    Route::post('/reports/{report}/take-down', [ModerationController::class, 'takeDown'])->name('reports.take-down');
    
    // Statistics
    Route::get('/statistics', [AdminDashboardController::class, 'statistics'])->name('statistics');
});


Route::middleware(['auth', 'account.active'])->prefix('api')->name('api.')->group(function () {
    
    // Tag Autocomplete
    Route::get('/tags/search', [TagController::class, 'search'])->name('tags.search');
    
    // Popular Tags
    Route::get('/tags/popular', [TagController::class, 'popular'])->name('tags.popular');
    
    // Quick Stats
    Route::get('/artworks/{artwork}/stats', [ArtworkController::class, 'stats'])->name('artworks.stats');
});