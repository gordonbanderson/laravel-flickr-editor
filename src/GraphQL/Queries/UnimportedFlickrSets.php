<?php

namespace Suilven\FlickrEditor\GraphQL\Queries;

use Suilven\FlickrEditor\Models\FlickrSet;

// @TODO change to orphaned photos by date
class UnimportedFlickrSets
{

    public function __invoke($rootValue, array $args)
    {
        return FlickrSet::where('imported', false)
            ->orderBy('title', 'desc')
            ->get();
    }
}