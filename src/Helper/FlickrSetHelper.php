<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Helper;

use Illuminate\Support\Facades\Log;
use Suilven\FlickrEditor\Events\FlickrSetImported;
use Suilven\FlickrEditor\Jobs\ImportPageOfPhotosFromSetJob;
use Suilven\FlickrEditor\Models\FlickrSet;

class FlickrSetHelper
{

    use PhotosetsAPITrait;

    public const EXTRAS = 'license, date_upload, date_taken, owner_name, icon_server, original_format, ' .
    ' last_update, geo, tags, machine_tags, o_dims, views, media, path_alias, url_t, url_s,' .
    ' url_q, url_m, url_n, url, url_z, url_c, url_h, url_k, url_l, url_o, description, url_sq';

    public const PAGE_SIZE = 500;


    /** @var string */
    private $flickrSetID;

    /** @var int */
    private $nPhotos;

    /** @var bool */
    private $importFromQueue;

    /** @var \Suilven\FlickrEditor\Models\FlickrSet */
    private $flickrSet;

    /**
     * FlickrSetHelper constructor.
     */
    public function __construct(string $flickrSetID, bool $importFromQueue = false)
    {
        $this->queueImport = $importFromQueue;
        $this->flickrSetID = $flickrSetID;
        $this->importFromQueue = $importFromQueue;

        /**
         * This will exist after importSet has been called once, so in the case of queued jobs, this is needed to
         * populate the FlickrSet variable
         *
         * @var \Suilven\FlickrEditor\Models\FlickrSet
         */
        $this->flickrSet = FlickrSet::where('flickr_id', '=', $this->flickrSetID)->first();
    }


    public function setNumberOfImages($newNPhotos)
    {
        $this->nPhotos = $newNPhotos;
    }


    /**
     * @param $title
     * @param $description
     * @return FlickrSet
     */
    public function findOrCreateFlickrSet($title, $description) {
        $set = FlickrSet::where('flickr_id', '=', $this->flickrSetID)->first();
        if (\is_null($set)) {
            $set = FlickrSet::create(['title' => $title, 'flickr_id' => $this->flickrSetID, 'description' => $description]);
        }

        return $set;
    }


    public function importSet(): void
    {
        $photosetsApi = $this->getPhotosetsAPI();

        // initially only grab one image, the goal being to find the number of photos in a set
        // config('flickreditor.flickrsets.import_page_size');
        $pageSize = self::PAGE_SIZE;

        $info = $photosetsApi->getInfo($this->flickrSetID, null);
        print_r($info);

        $photoset = $photosetsApi->getPhotos(
            $this->flickrSetID,
            null,
            self::EXTRAS,
            $pageSize,
            1
        );

       // \print_r($photoset) && die;

        $set = $this->findOrCreateFlickrSet($info['title'], $info['description']);

        // reset the set images back to empty.  If not multiple imports of the same set will reference the same image
        // multiple times, which breaks react key and the visual interface
        $set->flickrPhotos()->sync([]);

        $this->flickrSet = $set;

        $this->nPhotos = $photoset['total'];
        $nPages = \floor(1 + ($this->nPhotos) / self::PAGE_SIZE);

        if ($this->queueImport) {
            \error_log('>>>> QUEUE <<<<');
            // this will trigger subsequent jobs
            ImportPageOfPhotosFromSetJob::dispatch($this->flickrSetID, 1, $nPages, $this->nPhotos);
        } else {
            \error_log('>>>> NOT QUEUE <<<<');

            for ($i = 1; $i <= $nPages; $i++) {
                Log::debug('Adding job for page ' . $i);
                $this->importPage($i);
            }

            // @todo This should probably be after the exif data is imported
            \event(new FlickrSetImported($set));
        }
    }


    /** @param int $page The page number to import, starting at 1 */
    public function importPage(int $page): void
    {
        Log::debug('>>>>> IMPORT PAGE ' . $page . ' for set ' . $this->flickrSetID . ' <<<<<');
        $photosetsApi = $this->getPhotosetsAPI();


        $photoset = $photosetsApi->getPhotos(
            $this->flickrSetID,
            null,
            self::EXTRAS,
            self::PAGE_SIZE,
            $page
        );

        $photos = $photoset['photo'];

        $photoHelper = new FlickrPhotosHelper($this->importFromQueue);
        $ctr = 1;
        foreach ($photos as $photoArray) {
            $flickrPhoto = $photoHelper->importPhotoFromArray($photoArray, $ctr, $this->nPhotos);
                $flickrPhoto->flickrSets()->attach($this->flickrSet);
                $ctr++;
        }
    }

}
