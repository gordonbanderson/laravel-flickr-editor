import React from 'react';


function FlickrPhotoOrphanThumbnail(props) {
      return  <div className={"setPhoto"} key={props.id}>
        <img src={props.small_url} title={props.title}/>
    </div>
}

export default FlickrPhotoOrphanThumbnail;
