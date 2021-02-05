<?php

namespace Suilven\FlickrEditor\GraphQL\Queries;

use Illuminate\Support\Facades\DB;
use Suilven\FlickrEditor\Models\FlickrPhoto;

class NumberOfOrphanedPhotosByDate
{

    public function __invoke($rootValue, array $args)
    {
        // @todo filter out images already in a set
        $sql = <<< SQL
         select COUNT(*) as amount_of_photos,
         date(taken_at) as date_of_photos
         FROM flickr_photos
         GROUP BY date_of_photos
         ORDER BY date_of_photos DESC
        SQL;

        $data = DB::select($sql);

        return $data;
    }
}