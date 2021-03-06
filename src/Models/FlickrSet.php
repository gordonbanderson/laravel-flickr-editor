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
        'imported'
    ];

    public function flickrPhotos(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(FlickrPhoto::class);
    }
}
