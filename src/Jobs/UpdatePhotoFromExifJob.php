<?php

declare(strict_types = 1);

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

    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

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
     */
    public function handle(): void
    {
        $helper = new FlickrExifHelper();
        $helper->updateMetaDataFromExif($this->flickrID);
    }
}
