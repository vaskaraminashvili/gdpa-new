<?php

namespace App\Providers;

use App\Repositories\SlideRepository;
use App\Repositories\NewsRepository;
use App\Services\SlideService;
use App\Services\NewsService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SlideRepository::class, SlideRepository::class);
        $this->app->bind(SlideService::class, SlideService::class);
        $this->app->bind(NewsRepository::class, NewsRepository::class);
        $this->app->bind(NewsService::class, NewsService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
