<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Console\Commands;

use Illuminate\Console\Command;
use Suilven\FlickrEditor\Events\FlickrPhotoExifProcessed;
use Suilven\FlickrEditor\Events\TestEvent;
use Suilven\FlickrEditor\Helper\FlickrPhotosHelper;
use Suilven\FlickrEditor\Helper\FlickrSetHelper;
use Suilven\FlickrEditor\Models\FlickrPhoto;

class ImportOrphanPhotos extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flickr:import_orphan_photos {--queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all orphan photographs, for the purposes of adding to a set';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $queue = $this->option('queue');
/*
        $fp = FlickrPhoto::find(100);
        $event = new FlickrPhotoExifProcessed($fp);
        $this->info('Sending event');
        FlickrPhotoExifProcessed::dispatch($fp);

        for ($i=1; $i<=4;$i++) {
            TestEvent::dispatch('This is test event ' . $i , $fp);
        }

        die;
*/

        $this->info('Importing orphan Flickr photos');
        $helper = new FlickrPhotosHelper($queue);
        $helper->importOrphanPhotos();

        return 0;
    }
}
