<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Console\Commands;

use Illuminate\Console\Command;
use Suilven\FlickrEditor\Helper\FlickrSetsHelper;

class ImportAllSets extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flickr:import_all_sets {--queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import all flickr sets for current user';

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

        $this->info('Importing flickr sets ', $queue);
        $helper = new FlickrSetsHelper($queue);
        $helper->getSetsForUser();

        return 0;
    }
}
