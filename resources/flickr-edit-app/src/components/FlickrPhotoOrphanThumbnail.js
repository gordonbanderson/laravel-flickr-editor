import React from 'react';


function FlickrPhotoOrphanThumbnail(props) {
        return <img src={props.small_url} title={props.title}/>
}

export default FlickrPhotoOrphanThumbnail;
