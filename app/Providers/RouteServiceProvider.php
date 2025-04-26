<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;


class RouteServiceProvider extends ServiceProvider
{

    public const home = '/home';

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));
        });
    }

    public static function loadVersionedRoutes(string $version): void
    {
        $routePath = app_path("Http/Routes/{$version}");

        if (File::isDirectory($routePath)) {
            $files = File::files($routePath);

            foreach ($files as $file) {
                Route::prefix($version)
                    ->middleware('api')
                    ->group($file->getPathname());
            }
        }
    }


}
