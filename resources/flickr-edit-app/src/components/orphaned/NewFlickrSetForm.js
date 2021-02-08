import React, {useState} from 'react';
import {useMutation, useQuery} from "@apollo/client";
import gql from 'graphql-tag';
import {Link} from "react-router-dom";
import {Helmet} from "react-helmet";
import {FLICKR_PHOTO_SCREEN, getScreen, setScreen} from "../Screen";
import {useParams} from "react-router";
import {toast, ToastContainer} from 'react-toastify';
import {ADD_PHOTOS_TO_FLICKR_SET, CREATE_FLICKR_SET} from "../../constants";
import {useHistory} from "react-router-dom";

const NewFlickrSetForm = (props) => {
    // setScreen(FLICKR_PHOTO_SCREEN);
    let history = useHistory();

    const [titleInput, setTitleInput] = useState(props.title);
    const [descriptionInput, setDescriptionInput] = useState('');

    // @TODO
    const updateCache = (cache, {data}) => {
        // If this is for the public feed, do nothing
        if (isPublic) {
            return null;
        }
        // Fetch the todos from the cache
        const existingTodos = cache.readQuery({
            query: GET_MY_TODOS
        });
        // Add the new todo to the cache
        const newTodo = data.insert_todos.returning[0];
        cache.writeQuery({
            query: GET_MY_TODOS,
            data: {todos: [newTodo, ...existingTodos.todos]}
        });
    };

    const [createFlickrSet] = useMutation(CREATE_FLICKR_SET);
    const [addPhotosToSet] = useMutation(ADD_PHOTOS_TO_FLICKR_SET);
    console.log('NEW FLICKR SET FORM:', props);
    const photoIDs = props.photos.map(photo => Number(photo.id));

    return (
        <div>
        <form className="formInput" className={"form p-10"} onSubmit={(e) => {
            e.preventDefault();
            createFlickrSet({variables: { title: titleInput, description: descriptionInput }})
                .then((response) => {
                    toast('Flickr Set Created');

                    console.log('PROMISE' , response.data.createFlickrSet);
                    var setID = Number(response.data.createFlickrSet.id);
                    console.log('Set id', setID);
                    console.log('IN PROMISE RESPONSE PHOTO IDS', photoIDs);

                    addPhotosToSet({variables: { id: setID, photo_ids: photoIDs }})
                        .then((response) => {
                            toast('Images added');
                            console.log('After updating set images', response);
                            history.push('/edit/set/' + response.data.addPhotosToFlickrSet.id);
                        })

                })
            ;

        }}>
            <input
                className="input border"
                value={titleInput}
                onChange={e => (setTitleInput(e.target.value))}
            />

            <textarea
                className="input border"
                value={descriptionInput}
                onChange={e => (setDescriptionInput(e.target.value))}
            />

            <button className={"border rounded my-6 p-3"}>Create</button>
        </form>
            <ToastContainer position={"bottom-center"}/>
        </div>

    );
};


export default NewFlickrSetForm;