import React from 'react';
import {Link} from "react-router-dom";
import {FLICKR_PHOTO_SCREEN, setScreen} from "./Screen";


function FlickrPhotoThumbnail(props) {
      return <Link to={'/editor/edit/photo/'+props.id + `/set/`+props.setID} onClick={setScreen(FLICKR_PHOTO_SCREEN)}><img src={props.small_url} title={props.title}/></Link>;
}

FlickrPhotoThumbnail.defaultProps = {
    editable: false
}

export default FlickrPhotoThumbnail;
