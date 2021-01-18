import React from 'react';
import {GET_FLICKR_SET_LIST} from "../constants";
import {useQuery} from "@apollo/client";


function FlickrSets(props)  {
    const { loading, error, data } = useQuery(GET_FLICKR_SET_LIST);

    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error :(</p>;

    console.log(data);

    return data.flickr_sets.map(({ title, id }) => (
        <div key={id}>
            <p>
                {title}: {id}
            </p>
        </div>
    ));
}

export default FlickrSets;
