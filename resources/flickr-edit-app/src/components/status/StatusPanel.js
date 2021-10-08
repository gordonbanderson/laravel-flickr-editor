import React, {useEffect} from 'react';
import {Helmet} from 'react-helmet';

import Echo from "laravel-echo"

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: 'todoappkey',
    wsHost: window.location.hostname,
    wsPort: 6001,
    forceTLS: false,
    disableStats: true,
});




function StatusPanel(props)  {
    useEffect(() => {
        console.log('Status panel use effect');

        window.Echo.channel('flickr.photos').listen('.exif.processed', (e) => {
            console.log('FlickrPhotoExifProcessed', e);
        })

            .listen('.photo.imported',(e) => {
                console.log('Photo imported', e);
            })

            .listen('.orphan.imported',(e) => {
                console.log('Orphan photo imported', e);
            })


        return function cleanup() {
            console.log('Status panel clean up')
            // Echo.leave('flickr.photos');
        };
    });

    return <div>
        <Helmet><title>Status Panel</title></Helmet>
           <h1 className={"pt-4"}>Status Panel</h1>

        </div>
    ;
}

export default StatusPanel;
