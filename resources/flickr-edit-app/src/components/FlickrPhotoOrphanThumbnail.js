import React from 'react';
import {Link} from "react-router-dom";
import {FLICKR_PHOTO_SCREEN, setScreen} from "./Screen";


function FlickrPhotoOrphanThumbnail(props) {
      return  <div className={"setPhoto"} key={props.id}>
        <img src={props.small_url} title={props.title}/>
    </div>
}

export default FlickrPhotoOrphanThumbnail;
