<?php

declare(strict_types = 1);

namespace Suilven\FlickrEditor\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): \Illuminate\View\View
    {
        return \view('flickr-editor::layouts.app');
    }
}
