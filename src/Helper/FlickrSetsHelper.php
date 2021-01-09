<?php


namespace Suilven\FlickrEditor\Helper;

use Illuminate\Support\Facades\Log;
use Samwilson\PhpFlickr\PhotosetsApi;
use Suilven\FlickrEditor\Events\FlickrPhotoImported;
use Suilven\FlickrEditor\Events\FlickrSetImported;
use Suilven\FlickrEditor\Jobs\ImportPageOfPhotosFromSetJob;
use Suilven\FlickrEditor\Jobs\UpdatePhotoFromExifJob;
use Suilven\FlickrEditor\Models\FlickrPhoto;
use Suilven\FlickrEditor\Models\FlickrSet;

class FlickrSetsHelper
{

    use PhotosetsAPITrait;



    private $importFromQueue;



    public function __construct($importFromQueue = false)
    {
        $this->importFromQueue = $importFromQueue;

    }




    public function getSetsForUser()
    {
        $page = 1;
        $pages = 1e10;

        while ($page <= $pages) {
            $photoSetsAPI = $this->getPhotosetsAPI();
            $response = $photoSetsAPI->getList();
            $pages = $response['pages'];
            $sets = $response['photoset'];
            foreach($sets as $set) {
                Log::info('Set: ' . $set['id'] . $set['title']);

                $nPhotos = $set['photos'];
                $nPages = floor(1 + ($nPhotos) / FlickrSetHelper::PAGE_SIZE );

                if ($this->importFromQueue) {
                    error_log('>>>> QUEUE <<<<');
                    // this will trigger subsequent jobs
                    ImportPageOfPhotosFromSetJob::dispatch( $this->flickrSetID, 1, $nPages);

                } else {
                    error_log('>>>> NOT QUEUE <<<<');
                    $helper = new FlickrSetHelper($set['id'], $this->importFromQueue);

                    for ($i = 1; $i <= $nPages; $i++) {
                        Log::debug('Adding job for page ' . $i);
                        $helper->importPage($i);

                    }

                    event(new FlickrSetImported($set));
                }
            }

            $page++;
        }




    }


}