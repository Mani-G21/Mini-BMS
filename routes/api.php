<?php

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Auto-discover versioned routes
RouteServiceProvider::loadVersionedRoutes('v1');


Route::get('/ping', function() {
    return response()->json(['message' => 'PONG']);
});

Route::get('/redis-test', function() {
    Redis::set('ping', 'pong');
    return response()->json(['message' => Redis::get('ping')]);
});

//Route::prefix('v1')->group(function() {
//    require base_path('app/Http/Routes/v1/auth.php');
//});
