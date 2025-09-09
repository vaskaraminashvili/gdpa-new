<?php

namespace App\Providers;

use App\Repositories\SlideRepository;
use App\Repositories\NewsRepository;
use App\Repositories\GalleryRepository;
use App\Repositories\TrainingRepository;
use App\Repositories\ApplicantRepository;
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
        $this->app->bind(TrainingRepository::class, TrainingRepository::class);
        $this->app->bind(ApplicantRepository::class, ApplicantRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
