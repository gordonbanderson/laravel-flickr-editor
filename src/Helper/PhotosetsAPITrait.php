<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Helper;

use Samwilson\PhpFlickr\PhotosetsApi;

/**
 * Trait PhotosetsAPITrait
 *
 * @package Suilven\FlickrEditor\Helper
 *
 *  @phpcs:disable SlevomatCodingStandard.Classes.SuperfluousTraitNaming.SuperfluousSuffix
 */
trait PhotosetsAPITrait
{

    public function getPhotosetsAPI(): PhotosetsApi
    {
        $authHelper = new FlickrAuthHelper();
        $phpFlickr = $authHelper->getPhpFlickr();

        return new PhotosetsApi($phpFlickr);
    }
}
