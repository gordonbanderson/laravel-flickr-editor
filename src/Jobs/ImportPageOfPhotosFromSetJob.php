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
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $flickrID, $page, $numberOfPages)
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

        if ($this->page < $this->numberOfPages) {
            ImportPageOfPhotosFromSetJob::dispatch($this->flickrID, $this->page+1, $this->numberOfPages);
        } else {
            $set = FlickrSet::where('flickr_id', $this->flickrID)->first();
            \event(new FlickrSetImported($set));
        }
    }
}
