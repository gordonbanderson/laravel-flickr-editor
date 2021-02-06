import React, {useState} from 'react';
import {useMutation, useQuery} from "@apollo/client";
import gql from 'graphql-tag';
import {Link} from "react-router-dom";
import {Helmet} from "react-helmet";
import {FLICKR_PHOTO_SCREEN, getScreen, setScreen} from "./Screen";
import {useParams} from "react-router";
import {GET_FLICKR_PHOTO, GET_FLICKR_SET_PHOTO_IDS} from "../constants";
import {toast, ToastContainer} from 'react-toastify';



function FlickrPhotoThumbnail(props) {
      return  <div className={"setPhoto"} key={id.toString()}>
        <Link to={'/edit/photo/'+props.id + `/set/`+props.setID} onClick={setScreen(FLICKR_PHOTO_SCREEN)}><img src={props.small_url} title={props.title}/></Link>
    </div>
}

export default FlickrPhotoThumbnail;
