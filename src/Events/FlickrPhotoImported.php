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
        return 'photo.imported';
    }
}
