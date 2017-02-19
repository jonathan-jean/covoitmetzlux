<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');


Route::group(["middleware" => ["auth"]], function () {
    Route::get('/auth/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('logout');

    Route::get('/user', 'UserController@getUser')->name('profile');
    Route::post('/user', 'UserController@postUser')->name('profile');

    Route::get('/travel/create', 'TravelController@getCreate')->name('travel-create');
    Route::post('/travel/create', 'TravelController@postCreate')->name('travel-create');

    Route::get('/travel', 'TravelController@getIndex')->name('travel-index');


    Route::get('/travel/delete/{travel}', 'TravelController@getDelete')->name('travel-delete');

    Route::get('/travel/edit/{travel}', 'TravelController@getEdit')->name('travel-edit');
    Route::post('/travel/edit/{travel}', 'TravelController@postEdit')->name('travel-edit');

    Route::get('/travel/contact/{travel}', 'TravelController@getContact')->name('travel-contact');

    Route::get('/contact', 'ContactController@getIndex')->name('contact-index');
    Route::get('/contact/{contact}/decline', 'ContactController@getDecline')->name('contact-decline');
    Route::get('/contact/{contact}/accept', 'ContactController@getAccept')->name('contact-accept');
    Route::get('/contact', 'ContactController@getIndex')->name('contact-index');

});

Route::get('/travel/search', 'TravelController@getSearch')->name('travel-search');
Route::get('/travel/{travel}', 'TravelController@getDetails')->name('travel-details');

Route::group(["middleware" => ["guest"]], function () {
    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');
    Route::get('auth/{provider}', 'SocialAuthController@redirectToProvider');
    Route::get('auth/{provider}/callback', 'SocialAuthController@handleProviderCallback');
});
