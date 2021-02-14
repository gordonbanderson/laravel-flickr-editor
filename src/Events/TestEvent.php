<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Suilven\FlickrEditor\Models\FlickrPhoto;

class TestEvent implements ShouldBroadcast, ShouldQueue
{
    use Dispatchable;
    use SerializesModels;

    /** @var string */
    public $text;

    /** @var string */
    public $text2;

    /** @var FlickrPhoto */
    public $flickrPhoto;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($text, $flickrPhoto)
    {
        $this->text = $text;
        $this->flickrPhoto = $flickrPhoto;
        $this->text2 = 'This is text 2';
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return new Channel('flickr.photos');
    }

    public function broadcastAs()
    {
        return 'test';
    }
}