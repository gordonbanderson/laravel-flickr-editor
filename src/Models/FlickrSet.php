<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Models;

use Illuminate\Database\Eloquent\Model;

class FlickrSet extends Model
{
    protected $table = 'flickr_sets';

    protected $fillable = [
        'flickr_id',
        'title',
        'description',
        'is_dirty',
        'lock_geo',
    ];

    public function flickrPhotos()
    {
        return $this->belongsToMany(FlickrPhoto::class, 'flickr_set_flickr_photo');
    }
}
