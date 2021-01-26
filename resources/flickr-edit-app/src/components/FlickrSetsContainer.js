import React from 'react';
import {GET_FLICKR_SET_LIST} from "../constants";
import {useQuery} from "@apollo/client";
import {Link} from "react-router-dom";
import { Helmet } from 'react-helmet';
import {FLICKR_SET_SCREEN, FLICKR_SETS_SCREEN, getScreen, setScreen} from "./Screen";

function FlickrSetsContainer(props)  {

    return <FlickrSets page={1}/>
}

export default FlickrSets;
