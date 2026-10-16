<?php

namespace App\Providers;

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\Repositories\EtudiantRepositoryInterface;
use App\Contracts\Repositories\GroupeEtudiantRepositoryInterface;
use App\Repositories\Eloquent\EloquentEtudiantRepository;
use App\Repositories\Eloquent\EloquentGroupeEtudiantRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
     public function register(): void
    {
        $this->app->bind(
            EtudiantRepositoryInterface::class,
            EloquentEtudiantRepository::class
        );

        $this->app->bind(
            GroupeEtudiantRepositoryInterface::class,
            EloquentGroupeEtudiantRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
