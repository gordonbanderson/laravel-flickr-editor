<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Helper;

use Samwilson\PhpFlickr\PhotosApi;
use Samwilson\PhpFlickr\PhotosetsApi;

/**
 * Trait PhotosetsAPITrait
 *
 * @package Suilven\FlickrEditor\Helper
 *
 *  @phpcs:disable SlevomatCodingStandard.Classes.SuperfluousTraitNaming.SuperfluousSuffix
 */
trait PhotosAPITrait
{

    public function getPhotosAPI()
    {
        $authHelper = new FlickrAuthHelper();
        $phpFlickr = $authHelper->getPhpFlickr();

        return new PhotosApi($phpFlickr);
    }
}
