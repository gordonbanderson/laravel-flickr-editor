<?php


namespace Suilven\FlickrEditor\Helper;

use League\CLImate\CLImate;
use OAuth\Common\Storage\Memory;
use OAuth\OAuth1\Token\StdOAuth1Token;
use Samwilson\PhpFlickr\PhotosApi;
use Samwilson\PhpFlickr\PhotosetsApi;
use Samwilson\PhpFlickr\PhpFlickr;

class FlickrSetHelper
{

    public function importSet($flickrID)
    {
        $extras = 'license, date_upload, date_taken, owner_name, icon_server, original_format, ' .
            ' last_update, geo, tags, machine_tags, o_dims, views, media, path_alias, url_t, url_s,' .
            ' url_q, url_m, url_n, url, url_z, url_c, url_h, url_k, url_l, url_o, description, url_sq';

        $authHelper = new FlickrAuthHelper();
        $phpFlickr = $authHelper->getPhpFlickr();
        $photosetsApi = new PhotosetsApi($phpFlickr);

        $pageSize = config('flickreditor.flickrsets.import_page_size');

        $photoset = $photosetsApi->getPhotos(
            $flickrID,
            null,
            $extras,
            $pageSize,
            2
        );

        print_r($photoset);
    }
}