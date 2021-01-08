<?php

namespace Suilven\FlickrEditor\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Suilven\FlickrEditor\Models\FlickrPhoto;

class FlickrPhotoImported
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    /** @var FlickrPhoto */
    private $flickrPhoto;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(FlickrPhoto $flickrPhoto)
    {
        $this->flickrPhoto = $flickrPhoto;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
