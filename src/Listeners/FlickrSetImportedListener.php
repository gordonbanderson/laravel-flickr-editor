<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Listeners;

use Illuminate\Support\Facades\Log;
use Suilven\FlickrEditor\Events\FlickrSetImported;

class FlickrSetImportedListener
{
    /**
     * Handle the event.
     */
    public function handle(FlickrSetImported $event): void
    {
        Log::debug('Flickr Set Imported: ' . $event);
    }
}
