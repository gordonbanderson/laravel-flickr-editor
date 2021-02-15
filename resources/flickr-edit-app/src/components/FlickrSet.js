import React from 'react';
import {useQuery} from "@apollo/client";
import {Helmet} from 'react-helmet';
import {useParams} from "react-router";
import {GET_FLICKR_SET_PHOTOS} from "../constants";
import FlickrPhotoThumbnail from "./FlickrPhotoThumbnail";

function FlickrSet() {
    const {id} = useParams();


    const { loading, error, data } = useQuery(GET_FLICKR_SET_PHOTOS, {
        variables: { id: parseInt(id,10) },
    });


    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error :(</p>;

    let photos=data.flickr_set.flickrPhotos;

    console.log('FS PHOTOS', photos);

     return  (<div>
        <Helmet><title>Set: {data.flickr_set.title}</title></Helmet>
         <h1 className="pt-4 pb-4">{data.flickr_set.title}</h1>
        <ul className = "grid grid-cols-1 md:grid-cols-6" >
        {photos.map(({ title, id, small_url, small_height }, index) => (
            <li key={id} className={"setPhoto"}>
                {console.log(index)}<FlickrPhotoThumbnail id={id} prevID={index>0 ? photos[index-1].id : null} setID={data.flickr_set.id} small_url={small_url} title={title} editable={true}/>
            </li>
        ))}
    </ul></div>)

     ;
}

export default FlickrSet;
