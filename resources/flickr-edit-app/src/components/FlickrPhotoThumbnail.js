import React from 'react';
import {Link} from "react-router-dom";
import {FLICKR_PHOTO_SCREEN, setScreen} from "./Screen";


function FlickrPhotoThumbnail(props) {
      return  <div className={"setPhoto"} key={props.id}>
        <Link to={'/edit/photo/'+props.id + `/set/`+props.setID} onClick={setScreen(FLICKR_PHOTO_SCREEN)}><img src={props.small_url} title={props.title}/></Link>
    </div>
}

FlickrPhotoThumbnail.defaultProps = {
    editable: false
}

export default FlickrPhotoThumbnail;
