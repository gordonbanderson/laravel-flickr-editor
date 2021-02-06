<?php

namespace Suilven\FlickrEditor\GraphQL\Queries;

use Illuminate\Support\Facades\DB;
use Suilven\FlickrEditor\Models\FlickrPhoto;

class PhotosByDate
{

    public function __invoke($rootValue, array $args)
    {
        // @todo Outer join
        return FlickrPhoto::orphanedOnDate($args['date'])
            //->join('flickr_sets', 'flickr_photos.id', '=', 'flickr_photo_flickr_set.flickr_photo_id', 'full outer' )
            ->orderBy('taken_at')

            ->get();
    }
}