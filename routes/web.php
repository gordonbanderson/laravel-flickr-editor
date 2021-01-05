<?php

Route::get('/dashboard', function () {
    return view('boris::dashboard');
})->middleware(['auth'])->name('dashboard');

Route::group(['middleware' => ['web']], function() {
    Route::get('/', 'Suilven\FlickrEditor\Http\Controllers\HomeController@index')->name('home');
    Route::get('/search', 'Suilven\FlickrEditor\Http\Controllers\HomeController@search')->name('search');
    Route::get('/show/{slug}', 'Suilven\FlickrEditor\Http\Controllers\HomeController@show')->name('show');
});