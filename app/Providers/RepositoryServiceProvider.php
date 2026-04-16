<?php

namespace App\Providers;

use App\Core\Interfaces\AuthRepositoryInterface;
use App\Core\Interfaces\UserRepositoryInterface;
use App\Domain\Booking\Repositories\BookingLockServiceInterface;
use App\Domain\Booking\Repositories\BookingRepositoryInterface;
use App\Domain\Booking\Services\RedisBookingLockService;
use App\Domain\Movie\Repositories\CityRepositoryInterface;
use App\Domain\Movie\Repositories\MovieRepositoryInterface;
use App\Domain\Seat\Repositories\SeatRepositoryInterface;
use App\Domain\Show\Repositories\ShowRepositoryInterface;
use App\Domain\Theater\Repositories\TheaterRepositoryInterface;
use App\Infrastructure\Auth\Repositories\AuthRepository;
use App\Infrastructure\Auth\Repositories\UserRepository;
use App\Infrastructure\Booking\Repositories\BookingRepository;
use App\Infrastructure\Movie\Repositories\CityRepository;
use App\Infrastructure\Movie\Repositories\MovieRepository;
use App\Infrastructure\Seat\Repositories\SeatRepository;
use App\Infrastructure\Show\Repositories\ShowRepository;
use App\Infrastructure\Theater\Repositories\TheaterRepository;
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
        $this->app->bind(TheaterRepositoryInterface::class, TheaterRepository::class);
        $this->app->bind(ShowRepositoryInterface::class, ShowRepository::class);
        $this->app->bind(SeatRepositoryInterface::class, SeatRepository::class);
        $this->app->bind(BookingRepositoryInterface::class, BookingRepository::class);
        $this->app->bind(BookingLockServiceInterface::class, RedisBookingLockService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
