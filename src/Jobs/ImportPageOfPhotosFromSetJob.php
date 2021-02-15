<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Suilven\FlickrEditor\Events\FlickrSetImported;
use Suilven\FlickrEditor\Events\FlickrSetImportStatus;
use Suilven\FlickrEditor\Helper\FlickrSetHelper;
use Suilven\FlickrEditor\Models\FlickrSet;

class ImportPageOfPhotosFromSetJob implements ShouldQueue
{

    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /** @var string */
    private $flickrID;

    /** @var int */
    private $page;

    /** @var int */
    private $numberOfPages;

    /**
     * ImportPageOfPhotosFromSetJob constructor.
     */
    public function __construct(string $flickrID, int $page, int $numberOfPages)
    {
        Log::debug('Job constructor, page=' . $page .', fsid=' . $flickrID);
        $this->flickrID= $flickrID;
        $this->page = $page;
        $this->numberOfPages = $numberOfPages;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::debug('**** ImportPageOfPhotosFromSetJob page = ' . $this->page . ' **** set id=' . $this->flickrID);
        $helper = new FlickrSetHelper($this->flickrID, true);
        $helper->importPage($this->page);
        $set = FlickrSet::where('flickr_id', $this->flickrID)->first();



        if ($this->page < $this->numberOfPages) {
            FlickrSetImportStatus::dispatch("Importing page " . $this->page . " of " . $this->numberOfPages, $set);
            ImportPageOfPhotosFromSetJob::dispatch($this->flickrID, $this->page+1, $this->numberOfPages);
        } else {
            FlickrSetImportStatus::dispatch("Completed import of photographs, now updating EXIF data", $set);
        }
    }
}
