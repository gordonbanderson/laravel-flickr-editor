import React from 'react';
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

const methods = {
    componentDidMount(props) {
        console.log('I mounted! Here are my props: ', props);
    }
};


function StatusPanel(props)  {

    function componentDidMount() {
        //this.fetchInitialDataUsingHttp();
        console.log('Status panel did mount')

        //Set up listeners when the component is being mounted
        window.Echo.channel('flickr.photos').listen('.FlickrPhotoExifProcessed', (e) =>{
            console.log('FlickrPhotoExifProcessed', e);
        });

        /*
        .listen('OrderUpdated', (e) =>{

            this.updateOrder(e.order);
        }).listen('OrderDeleted', (e) =>{
            this.removeOrder(e.order);
        });
        */

    }

    function componentWillUnmount() {
        //@TODO: Disconnect echo
    }


    return <div>
        <Helmet><title>Status Panel</title></Helmet>
           <h1>Status Panel</h1>

        </div>
    ;
}

export default StatusPanel;
