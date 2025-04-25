<?php

namespace App\Providers;

use App\Core\Interfaces\AuthRepositoryInterface;
use App\Core\Interfaces\UserRepositoryInterface;
use App\Infrastructure\Auth\Repositories\AuthRepository;
use App\Infrastructure\Auth\Repositories\UserRepository;
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
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
