<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Helper;

use Illuminate\Support\Facades\Log;
use MStaack\LaravelPostgis\Geometries\Point;
use Suilven\FlickrEditor\Events\FlickrPhotoImported;
use Suilven\FlickrEditor\Events\FlickrSetImported;
use Suilven\FlickrEditor\Jobs\ImportPageOfPhotosFromSetJob;
use Suilven\FlickrEditor\Jobs\UpdatePhotoFromExifJob;
use Suilven\FlickrEditor\Models\FlickrPhoto;
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
            ImportPageOfPhotosFromSetJob::dispatch($this->flickrSetID, 1, $nPages);
        } else {
            \error_log('>>>> NOT QUEUE <<<<');

            for ($i = 1; $i <= $nPages; $i++) {
                Log::debug('Adding job for page ' . $i);
                $this->importPage($i);
            }

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

        foreach ($photos as $photoArray) {
                $flickrPhoto = $this->importPhotoFromArray($photoArray);
                $flickrPhoto->flickrSets()->attach($this->flickrSet);
        }
    }


    /** @param array<string, string|int|float|array<string, string|int|float>> $photoArray */
    private function importPhotoFromArray(array $photoArray): FlickrPhoto
    {
        $flickrPhoto = FlickrPhoto::where('flickr_id', $photoArray['id'])->first();
        if (\is_null($flickrPhoto)) {
            $flickrPhoto = new FlickrPhoto();
            $flickrPhoto->flickr_id = $photoArray['id'];
        }

        $flickrPhoto->title = $photoArray['title'];
        $flickrPhoto->description = isset($photoArray['description']) ? $photoArray['description'] : '';
        $flickrPhoto->is_public = $photoArray['ispublic'];

        $flickrPhoto->thumbnail_url = $photoArray['url_t'];
        $flickrPhoto->thumbnail_height = $photoArray['height_t'];
        $flickrPhoto->thumbnail_width = $photoArray['width_t'];

        $flickrPhoto->square_url = $photoArray['url_sq'];
        $flickrPhoto->square_height = $photoArray['height_sq'];
        $flickrPhoto->square_width = $photoArray['width_sq'];

        $flickrPhoto->original_url = $photoArray['url_o'];
        $flickrPhoto->original_height = $photoArray['height_o'];
        $flickrPhoto->original_width = $photoArray['width_o'];



        $flickrPhoto->small_url = $photoArray['url_s'];
        $flickrPhoto->small_height = $photoArray['height_s'];
        $flickrPhoto->small_width = $photoArray['width_s'];

        $flickrPhoto->small_url_320 = $photoArray['url_n'];
        $flickrPhoto->small_height_320 = $photoArray['height_n'];
        $flickrPhoto->small_width_320 = $photoArray['width_n'];

        $flickrPhoto->square_url = $photoArray['url_sq'];
        $flickrPhoto->square_height = $photoArray['height_sq'];
        $flickrPhoto->square_width = $photoArray['width_sq'];

        $flickrPhoto->square_url = $photoArray['url_sq'];
        $flickrPhoto->square_height = $photoArray['height_sq'];
        $flickrPhoto->square_width = $photoArray['width_sq'];

        $flickrPhoto->square_url = $photoArray['url_sq'];
        $flickrPhoto->square_height = $photoArray['height_sq'];
        $flickrPhoto->square_width = $photoArray['width_sq'];

        $flickrPhoto->square_url = $photoArray['url_sq'];
        $flickrPhoto->square_height = $photoArray['height_sq'];
        $flickrPhoto->square_width = $photoArray['width_sq'];

        $flickrPhoto->square_url = $photoArray['url_sq'];
        $flickrPhoto->square_height = $photoArray['height_sq'];
        $flickrPhoto->square_width = $photoArray['width_sq'];

        $flickrPhoto->medium_url_640 = $photoArray['url_z'];
        $flickrPhoto->medium_height_640 = $photoArray['height_z'];
        $flickrPhoto->medium_width_640 = $photoArray['width_z'];

        $flickrPhoto->medium_url = $photoArray['url_m'];
        $flickrPhoto->medium_height = $photoArray['height_m'];
        $flickrPhoto->medium_width = $photoArray['width_m'];

        $flickrPhoto->medium_url_800 = $photoArray['url_c'];
        $flickrPhoto->medium_height_800 = $photoArray['height_c'];
        $flickrPhoto->medium_width_800 = $photoArray['width_c'];

        $flickrPhoto->large_url = isset( $photoArray['url_l']) ?  $photoArray['url_l'] : null;
        $flickrPhoto->large_height = isset($photoArray['height_l']) ? $photoArray['height_l'] : null;
        $flickrPhoto->large_width= isset($photoArray['width_l']) ? $photoArray['width_l'] : null;

        $flickrPhoto->large_url_1600 = isset( $photoArray['url_h']) ?  $photoArray['url_h'] : null;
        $flickrPhoto->large_height_1600 = isset($photoArray['height_h']) ? $photoArray['height_h'] : null;
        $flickrPhoto->large_width_1600 = isset($photoArray['width_h']) ? $photoArray['width_h'] : null;

        $flickrPhoto->large_url_2048 = isset($photoArray['url_k']) ? $photoArray['url_k'] : null;
        $flickrPhoto->large_height_2048 = isset($photoArray['height_k']) ? $photoArray['height_k'] : null;
        $flickrPhoto->large_width_2048 = isset($photoArray['width_k']) ? $photoArray['width_k'] : null;

        Log::debug(print_r($photoArray, true));

        if (isset($photoArray['latitude']) && isset($photoArray['longitude'])) {
            Log::debug('****** LOCATION ******');
            $location = new Point((float) $photoArray['latitude'], (float) $photoArray['longitude']);

            $flickrPhoto->location = $location;

          //  Log::debug('Flickr photo location: ' . print_r($location, true));

            // if geographic location is provided, set lock geo to true, so that the editor has to make a conscious
            // decision to change photographic locations
            if ($this->flickrSet->lock_geo == false) {
                $this->flickrSet->lock_geo = true;
                $this->flickrSet->save();
            }
        }


   //     $flickrPhoto->flickr_last_updated = $photoArray['lastupdate'];
     //   $flickrPhoto->upload_unix_time_stamp = $photoArray['dateupload'];
        $flickrPhoto->taken_at = $photoArray['datetaken'];

        $flickrPhoto->save();

        \event(new FlickrPhotoImported($flickrPhoto));


        if ($this->importFromQueue) {
            UpdatePhotoFromExifJob::dispatch($flickrPhoto);
        } else {
            $helper = new FlickrExifHelper();
            $helper->updateMetaDataFromExif($flickrPhoto);
        }


/*
@todo
    [license] => 4
    [ownername] => gordon.b.anderson
    [pathalias] => gordonbanderson

    [latitude] => 0
    [longitude] => 0
    [accuracy] => 0

Check isprimary for the primary photo in a set

 */

        return $flickrPhoto;
    }
}
