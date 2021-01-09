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

trait PhotosetsAPITrait
{

    /**
     * @return PhotosetsApi
     */
    public function getPhotosetsAPI(): PhotosetsApi
    {
        $authHelper = new FlickrAuthHelper();
        $phpFlickr = $authHelper->getPhpFlickr();
        $photosetsApi = new PhotosetsApi($phpFlickr);
        return $photosetsApi;
    }
}