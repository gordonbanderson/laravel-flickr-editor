<?php

namespace Suilven\FlickrEditor\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Suilven\FlickrEditor\Helper\FlickrExifHelper;
use Suilven\FlickrEditor\Helper\FlickrSetHelper;
use Suilven\FlickrEditor\Models\FlickrPhoto;
use Suilven\FlickrEditor\Models\FlickrSet;

class UpdatePhotoFromExifJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /** @var string */
    private $flickrID;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(FlickrPhoto $flickrPhoto)
    {
        Log::debug('Updaing exif for photo ' . $flickrPhoto->flickr_id);
        $this->flickrID= $flickrPhoto;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::debug('**** UpdatePhotoFromExifJob page = ' . $this->flickrID);

        $helper = new FlickrExifHelper();
        $helper->updateMetaDataFromExif($this->flickrID);
    }
}
