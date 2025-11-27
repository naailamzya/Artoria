<?php

namespace App\Providers;

use App\Models\Artwork;
use App\Models\Category;
use App\Models\Challenge;
use App\Models\Comment;
use App\Models\Report;
use App\Models\User;
use App\Policies\ArtworkPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ChallengePolicy;
use App\Policies\CommentPolicy;
use App\Policies\ReportPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Artwork::class => ArtworkPolicy::class,
        Category::class => CategoryPolicy::class,
        Challenge::class => ChallengePolicy::class,
        Comment::class => CommentPolicy::class,
        Report::class => ReportPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}