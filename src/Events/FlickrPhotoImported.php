<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Suilven\FlickrEditor\Models\FlickrPhoto;

class FlickrPhotoImported implements ShouldBroadcast, ShouldQueue
{

    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /** @var \Suilven\FlickrEditor\Models\FlickrPhoto */
    public $flickrPhoto;


    public $ctr;

    public $totalPhotos;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(FlickrPhoto $flickrPhoto, $ctr, $totalPhotos)
    {
        $this->flickrPhoto = $flickrPhoto;
        $this->ctr = $ctr;
        $this->totalPhotos = $totalPhotos;
    }


    public function broadcastOn(): Channel
    {
        return new Channel('flickr.photos');
    }

    public function broadcastAs()
    {
        return 'photo.imported';
    }
}
