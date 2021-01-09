<?php

namespace Suilven\FlickrEditor\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Suilven\FlickrEditor\Helper\FlickrExifHelper;
use Suilven\FlickrEditor\Models\FlickrPhoto;

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
        $this->flickrID= $flickrPhoto;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $helper = new FlickrExifHelper();
        $helper->updateMetaDataFromExif($this->flickrID);
    }
}
