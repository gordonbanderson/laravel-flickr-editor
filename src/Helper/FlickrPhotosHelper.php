<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Helper;

use Illuminate\Support\Facades\Log;
use MStaack\LaravelPostgis\Geometries\Point;
use Suilven\FlickrEditor\Events\FlickrPhotoImported;
use Suilven\FlickrEditor\Jobs\ImportPageOfOrphanPhotosJob;
use Suilven\FlickrEditor\Jobs\UpdatePhotoFromExifJob;
use Suilven\FlickrEditor\Models\FlickrPhoto;

class FlickrPhotosHelper
{

    use PhotosAPITrait;

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


    public function __construct( bool $importFromQueue = false)
    {
        $this->importFromQueue = $importFromQueue;
    }




    public function importOrphanPhotos(): void
    {
        $photosAPI = $this->getPhotosAPI();

        // initially only grab one image, the goal being to find the number of photos in a set
        // config('flickreditor.flickrsets.import_page_size');
        $pageSize = self::PAGE_SIZE;


        $photos = $photosAPI->getNotInSet(null,
            null,
            null,
            null,
            null,
            null,
            self::EXTRAS,
            self::PAGE_SIZE,
            1
        );


        /*
         *     [photos] => Array
        (
            [page] => 1
            [pages] => 34
            [perpage] => 500
            [total] => 16505
            [photo] => Array
                (

         */

        $this->nPhotos = $photos['photos']['total'];
        $nPages = \floor(1 + ($this->nPhotos) / self::PAGE_SIZE);

        if ($this->importFromQueue) {
            \error_log('>>>> QUEUE <<<<');
            // this will trigger subsequent jobs
            ImportPageOfOrphanPhotosJob::dispatch( 1, $nPages);
        } else {
            \error_log('>>>> NOT QUEUE <<<<');

            for ($i = 1; $i <= $nPages; $i++) {
                Log::debug('Adding job for page ' . $i);
                $this->importPage($i);
            }

        }
    }


    /** @param int $page The page number to import, starting at 1 */
    public function importPage(int $page): void
    {
        Log::debug('>>>>> IMPORT ORPHANED PHOTOS PAGE ' . $page . ' for set ' . $this->flickrSetID . ' <<<<<');
        $photosAPI = $this->getPhotosAPI();


        $photosResponse = $photosAPI->getNotInSet(null,
            null,
            null,
            null,
            null,
            null,
            self::EXTRAS,
            self::PAGE_SIZE,
            $page
        );

        $photos = $photosResponse['photos']['photo'];

        foreach ($photos as $photoArray) {
                $flickrPhoto = $this->importPhotoFromArray($photoArray);
        }
    }


    /** @param array<string, string|int|float|array<string, string|int|float>> $photoArray */
    public function importPhotoFromArray(array $photoArray, $ctr = 0, $total = 0): FlickrPhoto
    {
        Log::debug('importPhotoFromArray total=' . $total);
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

        $flickrPhoto->medium_url_800 = isset( $photoArray['url_c']) ?  $photoArray['url_c'] : null;
        $flickrPhoto->medium_height_800 = isset($photoArray['height_c']) ? $photoArray['height_c'] : null;
        $flickrPhoto->medium_width_800 = isset($photoArray['width_c']) ? $photoArray['width_c'] : null;


        $flickrPhoto->large_url = isset( $photoArray['url_l']) ?  $photoArray['url_l'] : null;
        $flickrPhoto->large_height = isset($photoArray['height_l']) ? $photoArray['height_l'] : null;
        $flickrPhoto->large_width = isset($photoArray['width_l']) ? $photoArray['width_l'] : null;

        $flickrPhoto->large_url_1600 = isset( $photoArray['url_h']) ?  $photoArray['url_h'] : null;
        $flickrPhoto->large_height_1600 = isset($photoArray['height_h']) ? $photoArray['height_h'] : null;
        $flickrPhoto->large_width_1600 = isset($photoArray['width_h']) ? $photoArray['width_h'] : null;

        $flickrPhoto->large_url_2048 = isset($photoArray['url_k']) ? $photoArray['url_k'] : null;
        $flickrPhoto->large_height_2048 = isset($photoArray['height_k']) ? $photoArray['height_k'] : null;
        $flickrPhoto->large_width_2048 = isset($photoArray['width_k']) ? $photoArray['width_k'] : null;


        if (isset($photoArray['latitude']) && isset($photoArray['longitude'])) {
            $location = new Point((float) $photoArray['latitude'], (float) $photoArray['longitude']);
            $flickrPhoto->location = $location;
        }


   //     $flickrPhoto->flickr_last_updated = $photoArray['lastupdate'];
     //   $flickrPhoto->upload_unix_time_stamp = $photoArray['dateupload'];
        $flickrPhoto->taken_at = $photoArray['datetaken'];

        $flickrPhoto->save();

        FlickrPhotoImported::dispatch($flickrPhoto, $ctr, $total);

        if ($this->importFromQueue) {
            Log::debug('T1 UpdatePhotoFromExifJob ctr=' . $ctr .', nPhotos = ' . $total);
            UpdatePhotoFromExifJob::dispatch($flickrPhoto, $ctr, $total);
        } else {
            $helper = new FlickrExifHelper();
            $helper->setCounter($ctr);
            $helper->setNumberOfPhotos($total);
            $helper->updateMetaDataFromExif($flickrPhoto);
        }

        return $flickrPhoto;
    }
}
