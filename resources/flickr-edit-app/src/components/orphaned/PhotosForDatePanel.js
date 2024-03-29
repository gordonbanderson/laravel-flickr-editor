import React from 'react';
import {useParams} from "react-router";
import {GET_ORPHANED_PHOTOS_BY_DAY} from "../../constants";
import {useQuery} from "@apollo/client";
import {Helmet} from "react-helmet";
import NewFlickrSetForm from "./NewFlickrSetForm";
import FlickrPhotoOrphanThumbnail from "../FlickrPhotoOrphanThumbnail";

function PhotosForDatePanel(props)  {
    const {date} = useParams();

    const { loading, error, data } = useQuery(GET_ORPHANED_PHOTOS_BY_DAY, {
        variables: {date: date}
    });

    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error :(</p>;

    console.log(data);

    let photos=data.photos_by_date;

    return  (<div>
        <Helmet><title>Orphaned Photos for {date}</title></Helmet>
        <h1 className="pt-4">Orphaned Images for {date}</h1>
        <ul className = "grid grid-cols-1 md:grid-cols-6" >
            {photos.map(({ title, id, small_url, small_height }) => (
                <li key={id} className={"setPhoto"}>
                <FlickrPhotoOrphanThumbnail id={id} setID={null} small_url={small_url} title={title} />
                </li>
            ))}
        </ul>
        <NewFlickrSetForm title={date} photos={photos} />
    </div>)

}

export default PhotosForDatePanel;
