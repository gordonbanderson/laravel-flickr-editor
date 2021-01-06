<?php

namespace Suilven\FlickrEditor\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;


class FlickrSet extends Model
{
    protected $table = 'flickr_set';

    protected $fillable = [
        'flickr_id',
        'title',
        'description',
        'is_dirty',
        'lock_geo',
    ];

    public function flickrPhotos()
    {
        return $this->belongsToMany(FlickrPhoto::class,'flickr_set_flickr_photo');
    }

}
