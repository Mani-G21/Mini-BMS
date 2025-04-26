<?php

namespace App\Providers;

use App\Core\Interfaces\AuthRepositoryInterface;
use App\Core\Interfaces\UserRepositoryInterface;
use App\Domain\Movie\Repositories\CityRepositoryInterface;
use App\Domain\Movie\Repositories\MovieRepositoryInterface;
use App\Infrastructure\Auth\Repositories\AuthRepository;
use App\Infrastructure\Auth\Repositories\UserRepository;
use App\Infrastructure\Movie\Repositories\CityRepository;
use App\Infrastructure\Movie\Repositories\MovieRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(CityRepositoryInterface::class, CityRepository::class);
        $this->app->bind(MovieRepositoryInterface::class, MovieRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
