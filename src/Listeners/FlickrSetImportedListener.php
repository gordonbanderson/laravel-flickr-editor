<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Listeners;

use Suilven\FlickrEditor\Events\FlickrSetImported;

class FlickrSetImportedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }


    /**
     * Handle the event.
     */
    public function handle(FlickrSetImported $event): void
    {
    }
}
