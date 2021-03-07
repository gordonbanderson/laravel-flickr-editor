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
use Suilven\FlickrEditor\Helper\FlickrPhotosHelper;
use Suilven\FlickrEditor\Models\FlickrSet;

class ImportPageOfOrphanPhotosJob implements ShouldQueue
{

    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;


    /** @var int */
    private $page;

    /** @var int */
    private $numberOfPages;

    /**
     * ImportPageOfPhotosFromSetJob constructor.
     */
    public function __construct(int $page, int $numberOfPages)
    {
        Log::debug('Orphan photos job constructor, page=' . $page );
        $this->page = $page;
        $this->numberOfPages = $numberOfPages;
    }


    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::debug('**** ImportPageOfOrphanPhotosJob page = ' . $this->page . ' **** set id=');
        $helper = new FlickrPhotosHelper(true);
        $helper->importPage($this->page);

        if ($this->page < $this->numberOfPages) {
            ImportPageOfOrphanPhotosJob::dispatch( $this->page+1, $this->numberOfPages);
        } else {
            $set = FlickrSet::where('flickr_id', $this->flickrID)->first();
            \event(new FlickrSetImported($set));
        }
    }
}
