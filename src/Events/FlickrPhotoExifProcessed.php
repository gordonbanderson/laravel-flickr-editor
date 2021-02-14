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

class FlickrPhotoExifProcessed implements ShouldBroadcast, ShouldQueue
{

    use Dispatchable;
    use SerializesModels;

    public $afterCommit = true;

    /**
     * @var FlickrPhoto
     */
    public $flickrPhoto;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(FlickrPhoto $flickrPhoto)
    {
        $this->flickrPhoto = $flickrPhoto;
    }


    public function broadcastOn(): Channel
    {
        return new Channel('flickr.photos');
    }


    public function broadcastAs()
    {
        return 'exif.processed';
    }
}
