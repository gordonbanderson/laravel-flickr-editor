<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Helper;

use Illuminate\Support\Facades\Log;
use Samwilson\PhpFlickr\PhotosApi;
use Suilven\FlickrEditor\Events\FlickrPhotoExifProcessed;
use Suilven\FlickrEditor\Models\FlickrPhoto;

/**
 * Class FlickrExifHelper
 *
 * @package Suilven\FlickrEditor\Helper
 *
 * @phpcs:disable SlevomatCodingStandard.Classes.SuperfluousTraitNaming.SuperfluousSuffix
 */
class FlickrExifHelper
{

    /** @var int */
    private $counter;


    /** @var int */
    private $numberOfPhotos;

    /**
     * @param int $counter
     */
    public function setCounter(int $counter): void
    {
        $this->counter = $counter;
    }

    /**
     * @param int $numberOfPhotos
     */
    public function setNumberOfPhotos(int $numberOfPhotos): void
    {
        $this->numberOfPhotos = $numberOfPhotos;
    }


    public function updateMetaDataFromExif(FlickrPhoto $flickrPhoto): void
    {
        $photosAPI = $this->getPhotosAPI();
        $exifData = $photosAPI->getExif($flickrPhoto->flickr_id);

        foreach ($exifData as $oneExif) {
            if (!isset($oneExif['tag'])) {
                continue;
            }


            $tag = $oneExif['tag'];
            switch ($tag) {
                case 'FocalLength':
                    $raw = \str_replace(' mm', '', $exifData['raw']);
                    $focalLength35 = \intval($raw);
                    // model focal length
                    $flickrPhoto->focal_length_35mm = $focalLength35;

                    break;
                case 'ImageUniqueID':
                    $flickrPhoto->image_unique_id = $exifData['raw'];

                    break;
                case 'ISO':
                    $flickrPhoto->iso = $exifData['raw'];

                    break;
                case 'ExposureTime':
                    $flickrPhoto->shutter_speed = $exifData['raw'];

                    break;
                case 'FocalLengthIn35mmFormat':
                    $raw35 = $exifData['raw'];
                    $fl35 = \str_replace(' mm', '', $raw35);
                    $fl35 = (int) $fl35;
                    $flickrPhoto->focal_length_35mm = $fl35;

                    break;
                case 'Aperture':
                    $flickrPhoto->aperture = $exifData['raw'];

                    break;

                // Flickr appeared to have changed the tag to FNumber
                case 'FNumber':
                    $flickrPhoto->aperture = $exifData['raw'];

                    break;
                default:
                    // do nothing
                    break;
            }
        }

        $flickrPhoto->save();

        Log::debug('T2 UpdatePhotoFromExifJob ctr=' . $this->counter .', nPhotos = ' . $this->numberOfPhotos);

        FlickrPhotoExifProcessed::dispatch($flickrPhoto, $this->counter, $this->numberOfPhotos);
    }


    private function getPhotosAPI(): PhotosApi
    {
        $authHelper = new FlickrAuthHelper();
        $phpFlickr = $authHelper->getPhpFlickr();

        return new PhotosApi($phpFlickr);
    }
}
