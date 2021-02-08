import React from 'react';
import {useParams} from "react-router";
import {GET_ORPHANED_PHOTOS_BY_DAY} from "../../constants";
import {useQuery} from "@apollo/client";
import {Helmet} from "react-helmet";
import FlickrPhotoThumbnail from "../FlickrPhotoThumbnail";
import NewFlickrSetForm from "./NewFlickrSetForm";

function PhotosForDatePanel(props)  {
    const {date} = useParams();

    const { loading, error, data } = useQuery(GET_ORPHANED_PHOTOS_BY_DAY, {
        variables: {date: date}
    });

    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error :(</p>;

    console.log(data);

    /*

    const { loading, error, data } = useQuery(GET_FLICKR_SET_PHOTOS, {
        variables: { id: parseInt(id,10) },
    });



*/
    let photos=data.photos_by_date;

    return  (<div>
        <Helmet><title>Orphaned Photos for {date}</title></Helmet>
        <h1>Orphaned Images for {date}</h1>
        <div className = "grid grid-cols-1 md:grid-cols-6" >
            {photos.map(({ title, id, small_url, small_height }) => (
                <FlickrPhotoThumbnail id={id} setID={null} small_url={small_url} title={title} />
            ))}
        </div>
        <NewFlickrSetForm title={date} />
    </div>)

}

export default PhotosForDatePanel;
