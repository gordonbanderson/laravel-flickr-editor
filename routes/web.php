<?php

// @TODO override this to /
Route::group(['middleware' => ['web']], function() {
    Route::get('/editor', 'Suilven\FlickrEditor\Http\Controllers\FlickrEditorController@index');
;
    Route::get('/editor/{subPath}', 'Suilven\FlickrEditor\Http\Controllers\FlickrEditorController@index')
        ->where(['subPath' => '.*'])
        ->name('editor');
});
