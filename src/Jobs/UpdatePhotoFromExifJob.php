<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Suilven\FlickrEditor\Helper\FlickrExifHelper;
use Suilven\FlickrEditor\Models\FlickrPhoto;

class UpdatePhotoFromExifJob implements ShouldQueue
{

    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /** @var string */
    private $flickrPhoto;

    /** @var int */
    private $counter;


    /** @var int */
    private $numberOfPhotos;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(FlickrPhoto $flickrPhoto, int $counter, int $numberOfPhotos)
    {
        $this->flickrPhoto= $flickrPhoto;
        $this->counter = $counter;
        $this->numberOfPhotos = $numberOfPhotos;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::debug('Updating EXIF data for image '  . $this->flickrPhoto->flickr_id);
        $helper = new FlickrExifHelper();
        $helper->setCounter($this->counter);
        $helper->setNumberOfPhotos($this->numberOfPhotos);
        $helper->updateMetaDataFromExif($this->flickrPhoto);
    }
}
