<?php

namespace App\Providers;

use App\Interfaces\Ads\AdInterface;
use App\Interfaces\Auth\AuthInterface;
use App\Interfaces\Category\CategoryInterface;
use App\Interfaces\Reviews\ReviewInterface;
use App\Interfaces\User\UserInterface;
use App\Services\Ads\AdService;
use App\Services\Auth\AuthService;
use App\Services\Category\CategoryService;
use App\Services\Reviews\ReviewService;
use App\Services\User\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthInterface::class,AuthService::class);
        $this->app->bind(CategoryInterface::class,CategoryService::class);
        $this->app->bind(UserInterface::class,UserService::class);
        $this->app->bind(AdInterface::class,AdService::class);
        $this->app->bind(ReviewInterface::class,ReviewService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
