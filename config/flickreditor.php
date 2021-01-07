<?php

use Illuminate\Support\Str;

return [

    'flickrsets' => [
        // 500 is the max allowed
        'import_page_size' => env('FLICKR_SET_PAGE_IMPORT_SIZE', 20)
    ],

];
