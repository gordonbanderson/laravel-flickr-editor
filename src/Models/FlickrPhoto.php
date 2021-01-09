<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Models;

use Illuminate\Database\Eloquent\Model;

class FlickrPhoto extends Model
{
    protected $table = 'flickr_photos';

    protected $fillable = [
        'flickr_id',
        'title',
        'description',
        'location',
        'taken_at',
        'flickr_last_updated',
        'geo_is_public',
        'is_dirty',
        'is_public',
        'orientation',
        'rotation',
        'accuracy',
        'woe_id',
        'flickr_place_id',
        'aperture',
        'shutter_speed',
        'focal_length_35mm',
        'iso',
        'small_url',
        'small_height',
        'small_width',
        'small_url_320',
        'small_height_320',
        'small_width_320',
        'small_url_150',
        'small_height_150',
        'small_width_150',
        'medium_url',
        'medium_height',
        'medium_width',
        'medium_url_640',
        'medium_height_640',
        'medium_width_640',
        'medium_url_800',
        'medium_height_800',
        'medium_width_800',
        'square_url',
        'square_height',
        'square_width',
        'square_url_150',
        'square_height_150',
        'square_width_150',
        'large_url',
        'large_height',
        'large_width',
        'large_url_1600',
        'large_height_1600',
        'large_width_1600',
        'large_url_2048',
        'large_height_2048',
        'large_width_2048',
        'thumbnail_url',
        'thumbnail_height',
        'thumbnail_width',
        'original_url',
        'original_height',
        'original_width',
        'time_shift_hours',
        'exif_imported',
        'digital_zoom_ratio',
        'upload_unix_time_stamp',
        'perceptive_hash',
        'visible',
        'aspect_ratio',
        'image_unique_id',

    ];


    public function flickrSets(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(FlickrSet::class, 'flickr_photo_flickr_set');
    }
}
