<?php

namespace Suilven\FlickrEditor\Console\Commands;

use Illuminate\Console\Command;
use Suilven\Boris\Models\Quote;
use Suilven\FlickrEditor\Helper\FlickrSetHelper;

class ImportFlickrSet extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flickr:import_set {id} {--queue}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import a flickr set';

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
     *
     * @return int
     */
    public function handle()
    {
        $flickrSetID = $this->argument('id');
        $queue = $this->option('queue');

        $this->info('Importing flickr set ' . $flickrSetID, $queue);
        $helper = new FlickrSetHelper($flickrSetID, $queue);
        $helper->importSet();

        return 0;
    }




}