<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Console\Commands;

use Illuminate\Console\Command;
use Suilven\FlickrEditor\Helper\FlickrSetHelper;
use Suilven\FlickrEditor\Helper\FlickrSetsHelper;

class ImportFlickrSetMeta extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flickr:import_sets_meta {--queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import list of flickr sets without importing images';

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

        $this->info('Importing meta data for sets', $queue);
        $helper = new FlickrSetsHelper();
        $setsMetaData = $helper->getSetsForUser();

        print_r($setsMetaData);

        return 0;
    }
}
