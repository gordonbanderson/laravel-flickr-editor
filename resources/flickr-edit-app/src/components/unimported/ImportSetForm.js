import React from 'react';
import {useMutation} from "@apollo/client";
import {useHistory} from "react-router-dom";
import {ToastContainer} from 'react-toastify';
import {ADD_PHOTOS_TO_FLICKR_SET, CREATE_FLICKR_SET} from "../../constants";

const ImportSetForm = (props) => {
    // setScreen(FLICKR_PHOTO_SCREEN);
    let history = useHistory();


    const [createFlickrSet] = useMutation(CREATE_FLICKR_SET);
    const [addPhotosToSet] = useMutation(ADD_PHOTOS_TO_FLICKR_SET);
    console.log('NEW FLICKR SET FORM:', props);
    const photoIDs = props.photos.map(photo => Number(photo.id));

    return (
        <div>
        <form className="formInput" className={"form p-10"} onSubmit={(e) => {
            e.preventDefault();


        }}>

            <button className={"border rounded my-6 p-3"}>Import</button>
        </form>
            <ToastContainer position={"bottom-center"}/>
        </div>

    );
};


export default NewFlickrSetForm;