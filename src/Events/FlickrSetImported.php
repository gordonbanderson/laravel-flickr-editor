<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Suilven\FlickrEditor\Models\FlickrSet;

class FlickrSetImported
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


    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('channel-name');
    }
}
