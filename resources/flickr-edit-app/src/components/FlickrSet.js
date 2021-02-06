import React from 'react';
import {useQuery} from "@apollo/client";
import {Link} from "react-router-dom";
import {Helmet} from 'react-helmet';
import {FLICKR_PHOTO_SCREEN, setScreen} from "./Screen";
import {useParams} from "react-router";
import {GET_FLICKR_SET_PHOTOS} from "../constants";
import FlickrPhotoThumbnail from "./FlickrPhotoThumbnail";

function FlickrSet() {
    const {id} = useParams();


    console.log('FS ID', id);

    /*
    query ($limit: Int!) {
          flickr_set(limit: $limit) {
            id
            title
          }
        }
     */
    const { loading, error, data } = useQuery(GET_FLICKR_SET_PHOTOS, {
        variables: { id: parseInt(id,10) },
    });


    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error :(</p>;

    console.log('Data', data.flickr_set);

    /*
    render() {
    return (<div>
    {this.state.people.map((person, index) => (
        <p>Hello, {person.name} from {person.country}!</p>
    ))}
    </div>);
}
     */

    let photos=data.flickr_set.flickrPhotos;

     return  (<div>
        <Helmet><title>Set: {data.flickr_set.title}</title></Helmet>
        <div className = "grid grid-cols-1 md:grid-cols-6" >
        {photos.map(({ title, id, small_url, small_height }) => (
            <FlickrPhotoThumbnail id={id} setID={data.flickr_set.id} small_url={small_url} title={title} />
        ))}
    </div></div>)

     ;
}

export default FlickrSet;
