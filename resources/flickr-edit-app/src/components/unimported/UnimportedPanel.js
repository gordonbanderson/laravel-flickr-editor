import React from 'react';
import {Helmet} from 'react-helmet';
import {useQuery} from "@apollo/client";
import {GET_UNIMPORTED_FLICKR_SET_LIST} from "../../constants";
import {FLICKR_SET_SCREEN, getScreen, setScreen} from "../Screen";
import {Link} from "react-router-dom";

function UnimportedPanel(props)  {
    const { loading, error, data } = useQuery(GET_UNIMPORTED_FLICKR_SET_LIST);

    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error :(</p>;

    console.log(data);

    // see https://reactjs.org/docs/lists-and-keys.html, issue with keys

    console.log('FSETS - getScreen=', getScreen());

    return <div>
        <Helmet><title>Unimported Flickr Sets</title></Helmet>
        <h1 className="pt-4 pb-2">Unimported Sets</h1>

        <ul>
        {data.unimported_flickr_sets.map(({ title, id, imported }) => (
                <li key={id}>
                    <Link to={`/edit/set/`+id} onClick={setScreen(FLICKR_SET_SCREEN)}>{title}</Link>
                </li>
        ))}
        </ul>
    </div>
        ;
}

export default UnimportedPanel;
