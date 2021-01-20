import React from 'react';
import {GET_FLICKR_SET_LIST} from "../constants";
import {useQuery} from "@apollo/client";
import {Link} from "react-router-dom";
import { Helmet } from 'react-helmet';


function FlickrSets(props)  {
    const { loading, error, data } = useQuery(GET_FLICKR_SET_LIST);

    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error :(</p>;

    console.log(data);

    // see https://reactjs.org/docs/lists-and-keys.html, issue with keys

    return <div>
        <Helmet><title>Flickr Sets</title></Helmet>

        {data.flickr_sets.map(({ title, id }) => (
        <ul>
            <li key={id.toString()}>
                <Link to={`/show/`+id}>Set {title}</Link>
            </li>
        </ul>
        ))}</div>;
}

export default FlickrSets;
