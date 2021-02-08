<?php

namespace Suilven\FlickrEditor\GraphQL\Queries;

use Suilven\FlickrEditor\Models\FlickrPhoto;

class Greet
{

    public function __invoke($rootValue, array $args)
    {
        $photos = FlickrPhoto::get()->take(10);
        return $photos;
    }
}