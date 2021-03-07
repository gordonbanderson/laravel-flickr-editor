<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Listeners;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Suilven\FlickrEditor\Events\FlickrSetImported;

class FlickrSetImportedListener
{
    /**
     * Handle the event.
     */
    public function handle(FlickrSetImported $event): void
    {
        $set = $event->getFlickrSet();
        Log::debug('Finished importing set ' . $set->flickr_id);

        // orientation
        DB::table('flickr_photos')->whereRaw('original_width > original_height AND orientation is null')->update(['orientation' => 0]);
        DB::table('flickr_photos')->whereRaw('original_width <= original_height AND orientation is null')->update(['orientation' => 90]);

        // aspect ratio - note that PostgreSQL will equate int/int as an int, hence casting the width to be a float
        DB::statement('UPDATE flickr_photos SET aspect_ratio = original_width::float/original_height WHERE aspect_ratio IS NULL');

        // mark set as imported
        $set->update(['imported' => true]);
    }
}
