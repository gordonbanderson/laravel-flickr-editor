<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Suilven\FlickrEditor\Models\FlickrSet;

class FlickrSetImportStatus implements ShouldBroadcast, ShouldQueue
{

    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /** @var \Suilven\FlickrEditor\Models\FlickrSet */
    public $flickrSet;

    /** @var string */
    public $status;

    /**
     * FlickrSetImportStatus constructor.
     * @param string $status
     * @param FlickrSet $flickrSet
     */
    public function __construct($status, FlickrSet $flickrSet)
    {
        $this->flickrSet = $flickrSet;
        $this->status = $status;
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

    public function broadcastAs()
    {
        return 'set.imported';
    }
}
