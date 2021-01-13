<?php

Route::group(['middleware' => ['web']], function() {
    Route::get('/editor', 'Suilven\FlickrEditor\Http\Controllers\FlickrEditorController@index')->name('editor');
});
