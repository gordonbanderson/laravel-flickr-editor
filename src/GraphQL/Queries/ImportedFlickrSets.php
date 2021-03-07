<?php

namespace Suilven\FlickrEditor\GraphQL\Queries;

use Suilven\FlickrEditor\Models\FlickrSet;

// @TODO change to orphaned photos by date
class ImportedFlickrSets
{

    public function __invoke($rootValue, array $args)
    {
        return FlickrSet::where('imported', true)
            ->orderBy('title', 'desc')
            ->get();

        /*
        return FlickrSet::get()
            ->orderBy('title', 'desc')
            ->where('imported', true)
;
        */
    }
}