<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Models;

use Illuminate\Database\Eloquent\Model;

class FlickrTag extends Model
{
    protected $table = 'flickr_sets';

    protected $fillable = [
        'flickr_id',
        'value',
        'raw_value',
    ];

    public function flickrPhotos()
    {
        return $this->belongsToMany(FlickrPhoto::class, 'flickr_photo_flickr_tag');
    }
}
