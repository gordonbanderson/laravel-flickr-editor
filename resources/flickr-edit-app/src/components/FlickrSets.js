import React from 'react';
import {GET_FLICKR_SET_LIST, GET_IMPORTED_FLICKR_SET_LIST} from "../constants";
import {useQuery} from "@apollo/client";
import {Link} from "react-router-dom";
import {Helmet} from 'react-helmet';
import {FLICKR_SET_SCREEN, getScreen, setScreen} from "./Screen";

function FlickrSets(props)  {
    const { loading, error, data } = useQuery(GET_IMPORTED_FLICKR_SET_LIST);

    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error :(</p>;

    console.log(data);

    // see https://reactjs.org/docs/lists-and-keys.html, issue with keys

    console.log('FSETS - getScreen=', getScreen());

    return <div>
        <Helmet><title>Flickr Sets</title></Helmet>
        <ul>

        {data.imported_flickr_sets.map(({ title, id, imported }) => (
            <li key={id}>
                <Link to={`/edit/set/`+id} onClick={setScreen(FLICKR_SET_SCREEN)}>Set {title}</Link>
            </li>
        ))}
        </ul>
    </div>
    ;
}

export default FlickrSets;
