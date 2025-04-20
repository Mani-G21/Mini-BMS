<?php

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::get('/ping', function(){
    return response()->json(['Message' => 'pong']);
});

Route::get('/redis-test', function(){
    Redis::set('ping', 'pong');
    return response()->json(['Message' => Redis::get('ping')]);
});

Route::prefix('v1')->group(function(){
    require base_path('app/Http/Routes/v1/auth.php');
});