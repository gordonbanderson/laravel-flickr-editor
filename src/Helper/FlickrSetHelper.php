<?php


namespace Suilven\FlickrEditor\Helper;

use Illuminate\Support\Facades\Log;
use League\CLImate\CLImate;
use OAuth\Common\Storage\Memory;
use OAuth\OAuth1\Service\Flickr;
use OAuth\OAuth1\Token\StdOAuth1Token;
use Samwilson\PhpFlickr\PhotosApi;
use Samwilson\PhpFlickr\PhotosetsApi;
use Samwilson\PhpFlickr\PhpFlickr;
use Suilven\FlickrEditor\Jobs\ImportPageOfPhotosFromSetJob;
use Suilven\FlickrEditor\Models\FlickrPhoto;
use Suilven\FlickrEditor\Models\FlickrSet;

class FlickrSetHelper
{

    private $queueImport;

    private $flickrID;

    private $nPhotos;

    private $importFromQueue;

    const EXTRAS = 'license, date_upload, date_taken, owner_name, icon_server, original_format, ' .
    ' last_update, geo, tags, machine_tags, o_dims, views, media, path_alias, url_t, url_s,' .
    ' url_q, url_m, url_n, url, url_z, url_c, url_h, url_k, url_l, url_o, description, url_sq';

    const PAGE_SIZE = 500;

    public function __construct($flickrID, $importFromQueue = false)
    {
        $this->queueImport = $importFromQueue;
        $this->flickrID = $flickrID;
        $this->importFromQueue = $importFromQueue;
    }

    /**
     * @param string $flickrID
     * @param boolean $importFromQueue
     */
    public function importSet()
    {
        $set = $this->findOrCreateSet();

        error_log('N photos: ' . $this->nPhotos);
    }


    private function findOrCreateSet()
    {
        $photosetsApi = $this->getPhotosetsAPI();

        // initially only grab one image, the goal being to find the number of photos in a set
        $pageSize = self::PAGE_SIZE; // config('flickreditor.flickrsets.import_page_size');

        $photoset = $photosetsApi->getPhotos(
            $this->flickrID,
            null,
            self::EXTRAS,
            $pageSize,
            1
        );

        //print_r($photoset);


        $set = FlickrSet::where('flickr_id', '=', $this->flickrID)->first();

        if (is_null($set)) {
            $set = FlickrSet::create(['title' => $photoset['title'], 'flickr_id' => $this->flickrID]);
        }

        $this->nPhotos = $photoset['total'];
        $nPages = ($this->nPhotos) / self::PAGE_SIZE + 1;

        if ($this->queueImport) {
            error_log('>>>> QUEUE <<<<');
            // this will trigger subsequent jobs
            ImportPageOfPhotosFromSetJob::dispatch($this->flickrID, 1, $nPages);

        } else {
            error_log('>>>> NOT QUEUE <<<<');

            for ($i = 1; $i <= $nPages; $i++) {
                Log::debug('Adding job for page ' . $i);
                //ImportPageOfPhotosFromSetJob::dispatchSync($set, $i);
                $this->importPage($i);
                die;
            }
        }

    }

    /**
     * @param int $page The page number to import, starting at 1
     */
    public function importPage($page)
    {
        $photosetsApi = $this->getPhotosetsAPI();

        $photoset = $photosetsApi->getPhotos(
            $this->flickrID,
            null,
            self::EXTRAS,
            self::PAGE_SIZE,
            $page
        );

        $photos = $photoset['photo'];
        foreach($photos as $photoArray)
        {
            error_log('----------');
            error_log(print_r($photoArray));
            $this->importPhotoFromArray($photoArray);
        }
    }

    /**
     * @return PhotosetsApi
     */
    private function getPhotosetsAPI(): PhotosetsApi
    {
        $authHelper = new FlickrAuthHelper();
        $phpFlickr = $authHelper->getPhpFlickr();
        $photosetsApi = new PhotosetsApi($phpFlickr);
        return $photosetsApi;
    }

    private function importPhotoFromArray($photoArray)
    {
        $flickrPhoto = FlickrPhoto::where('flickr_id', $photoArray['id'])->first();
        if (is_null($flickrPhoto)) {
            $flickrPhoto = new FlickrPhoto();
            $flickrPhoto->flickr_id = $photoArray['id'];
        }

        $flickrPhoto->title = $photoArray['title'];
        $flickrPhoto->title = $photoArray['description'];
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

        $flickrPhoto->large_url = $photoArray['url_l'];
        $flickrPhoto->large_height = $photoArray['height_l'];
        $flickrPhoto->large_width = $photoArray['width_l'];

        $flickrPhoto->large_url_1600 = $photoArray['url_h'];
        $flickrPhoto->large_height_1600 = $photoArray['height_h'];
        $flickrPhoto->large_width_1600 = $photoArray['width_h'];

        $flickrPhoto->large_url_2048 = $photoArray['url_k'];
        $flickrPhoto->large_height_2048 = $photoArray['height_k'];
        $flickrPhoto->large_width_2048 = $photoArray['width_k'];


   //     $flickrPhoto->flickr_last_updated = $photoArray['lastupdate'];
     //   $flickrPhoto->upload_unix_time_stamp = $photoArray['dateupload'];
        $flickrPhoto->taken_at = $photoArray['datetaken'];

        $flickrPhoto->save();

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














    }


}