<?php

namespace App\Providers;

use App\Repositories\SlideRepository;
use App\Repositories\NewsRepository;
use App\Repositories\GalleryRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SlideRepository::class, SlideRepository::class);
        $this->app->bind(NewsRepository::class, NewsRepository::class);
        $this->app->bind(GalleryRepository::class, GalleryRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
