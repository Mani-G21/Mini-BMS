<?php

use App\Mail\MailTrapTesting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test/mail', function(){
    Mail::to('mani@gmail.com')
        ->send(new MailTrapTesting());
});