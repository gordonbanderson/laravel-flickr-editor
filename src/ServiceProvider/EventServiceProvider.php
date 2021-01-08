<?php

namespace Suilven\FlickrEditor\ServiceProvider;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Suilven\FlickrEditor\Events\FlickrPhotoExifProcessed;
use Suilven\FlickrEditor\Events\FlickrPhotoImported;
use Suilven\FlickrEditor\Events\FlickrSetImported;
use Suilven\FlickrEditor\Listeners\FlickrSetImportedListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        FlickrSetImported::class => [
            FlickrSetImportedListener::class,
        ],
        FlickrPhotoExifProcessed::class => [],
        FlickrPhotoImported::class => []
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}