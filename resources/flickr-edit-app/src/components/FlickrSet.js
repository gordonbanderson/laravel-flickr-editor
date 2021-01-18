import React from 'react';
import {useQuery} from "@apollo/client";
import gql from 'graphql-tag';
import {Link} from "react-router-dom";

function FlickrSet(props) {
    console.log(props);

    const { loading, error, data } = useQuery(gql`
        {
          flickr_set(id: 2) {
            title
            description
            flickrPhotos {
              title
              description
              small_url
              small_width
              small_height
              id
            }
          }
        }
    `);


    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error :(</p>;

    console.log('Data', data.flickr_set);

    return data.flickr_set.flickrPhotos.map(({ title, id, small_url }) => (
        <ul>
            <li key={id.toString()}>
                <img src={small_url} title={title} />
            </li>
        </ul>
    ));
}

export default FlickrSet;
