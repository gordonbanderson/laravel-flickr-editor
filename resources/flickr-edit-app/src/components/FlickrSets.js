import React from 'react';
import {GET_FLICKR_SET_LIST} from "../constants";
import {useQuery} from "@apollo/client";


function FlickrSets(props)  {
    const { loading, error, data } = useQuery(GET_FLICKR_SET_LIST);

    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error :(</p>;

    console.log(data);

    // see https://reactjs.org/docs/lists-and-keys.html, issue with keys

    return data.flickr_sets.map(({ title, id }) => (
        <ul>
            <li key={id.toString()}>
                <a href={"/editor/set/"+id}>{title}: {id}</a>
            </li>
        </ul>
    ));
}

export default FlickrSets;
