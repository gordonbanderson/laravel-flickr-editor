<?php

namespace Suilven\FlickrEditor\GraphQL\Mutations;

use Suilven\FlickrEditor\Models\FlickrSet;

class AddPhotosToFlickrSet
{
    /**
     * @param  null  $_
     * @param  array<string, mixed>  $args
     */
    public function __invoke($_, array $args)
    {
        // You can use sync function like $product->related()->sync(/* product ids array */); to manage the relation.
        $id = $args['id'];
        $photoIDs = $args['photo_ids'];

        $set = FlickrSet::find($id);
        $set->flickrPhotos()->sync($photoIDs);
        return $set;
    }
}
