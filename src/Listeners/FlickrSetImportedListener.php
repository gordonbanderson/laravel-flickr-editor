<?php

namespace Suilven\FlickrEditor\Listeners;

use App\Events\FlickrSetImported;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class FlickrSetImportedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  FlickrSetImported  $event
     * @return void
     */
    public function handle(FlickrSetImported $event)
    {
        //
    }
}
