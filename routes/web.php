<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(["middleware" => ["auth"]], function () {
    Route::get('/auth/logout', function () {
        Auth::logout();
        return redirect('/');
    });
});

Route::get('/home', function () {
    return view('auth.login');
});

Route::group(["middleware" => ["guest"]], function () {
    Route::get('/login', function () {
        return view('auth.login');
    });
    Route::get('auth/{provider}', 'SocialAuthController@redirectToProvider');
    Route::get('auth/{provider}/callback', 'SocialAuthController@handleProviderCallback');
});
