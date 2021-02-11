<?php

namespace Suilven\FlickrEditor\GraphQL\Queries;

use Illuminate\Support\Facades\DB;
use Suilven\FlickrEditor\Models\FlickrPhoto;

// @TODO change to orphaned photos by date
class PhotosByDate
{

    public function __invoke($rootValue, array $args)
    {
        return FlickrPhoto::orphanedOnDate($args['date'])
            ->whereNotIn('id', function ($query) {
                //DB::table('flickr_photo_flickr_set')->select('flickr_photo_id')->get()->toArray())
                $query->select('flickr_photo_id')->from('flickr_photo_flickr_set');
            })
            ->orderBy('taken_at')
            ->get();
    }
}