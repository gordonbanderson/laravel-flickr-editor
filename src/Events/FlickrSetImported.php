<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Suilven\FlickrEditor\Models\FlickrSet;

class FlickrSetImported implements ShouldBroadcast, ShouldQueue
{

    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /** @var \Suilven\FlickrEditor\Models\FlickrSet */
    private $flickrSet;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(FlickrSet $flickrSet)
    {
        $this->flickrSet = $flickrSet;
    }

    /**
     * @return FlickrSet
     */
    public function getFlickrSet(): FlickrSet
    {
        return $this->flickrSet;
    }


    public function broadcastOn(): Channel
    {
        return new Channel('flickr.sets');
    }
}
