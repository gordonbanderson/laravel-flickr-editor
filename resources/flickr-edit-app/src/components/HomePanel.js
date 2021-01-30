import React from 'react';
import {GET_FLICKR_SET_LIST} from "../constants";
import {useQuery} from "@apollo/client";
import {Link} from "react-router-dom";
import { Helmet } from 'react-helmet';
import {FLICKR_SET_SCREEN, FLICKR_SETS_SCREEN, getScreen, setScreen} from "./Screen";

function HomePanel(props)  {


    return <div>
        <Helmet><title>Flickr Editor</title></Helmet>
        <ul>
            <li><Link to={'edit/sets'}>Edit Imported Sets</Link></li>
            <li><Link to={'/import/sets'}>Import Unimported Sets</Link></li>
            <li><Link to={'/orphan/photos'}>Organise Orphan Photos</Link></li>
        </ul>
        </div>
    ;
}

export default HomePanel;
