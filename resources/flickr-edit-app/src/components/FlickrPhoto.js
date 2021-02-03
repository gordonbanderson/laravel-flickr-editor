import React, {useState} from 'react';
import {useQuery, useMutation} from "@apollo/client";
import gql from 'graphql-tag';
import {Link} from "react-router-dom";
import {Helmet} from "react-helmet";
import {FLICKR_PHOTO_SCREEN, getScreen, setScreen} from "./Screen";
import {useParams} from "react-router";
import {GET_FLICKR_PHOTO, GET_FLICKR_SET_PHOTO_IDS} from "../constants";
import { ToastContainer, toast } from 'react-toastify';

//const [todoInput, setTodoInput] = useState('');

const UPDATE_PHOTO = gql`
  mutation UpdatePhoto($id: Int!, $title: String!, $description: String!) {
    update_photo(id: $id, title: $title, description: $description) {
      id
      title
      description
    }
  }
`;


const FlickrPhotoForm = (props) => {
    let photo = props.photo;
    setScreen(FLICKR_PHOTO_SCREEN);

    const [titleInput, setTitleInput] = useState(photo.title);
    const [descriptionInput, setDescriptionInput] = useState(photo.description);

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

    const [updatePhoto] = useMutation(UPDATE_PHOTO);

    console.log('Form', props);


    return (
        <form className="formInput" className={"form p-10"} onSubmit={(e) => {
            e.preventDefault();
            updatePhoto({variables: {id: parseInt(photo.id), title: titleInput, description: descriptionInput }});
            toast('Image information updated');
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

            <button className={"border rounded my-6 p-3"}>Save</button>
        </form>

    );
};


const prevID = (ids, id) =>
{
    var prevID = null;
    for (let i=0; i < ids.length; i++) {
        if (ids[i] == id) {
            break;
        }

        prevID = ids[i];
    }

    return prevID;
}



const nextID = (ids, id) =>
{
    var nextID = null;
    for (let i=ids.length; i >= 0; i--) {
        if (ids[i] == id) {
            break;
        }

        nextID = ids[i];
    }

    return nextID;
}

const PrevPhotoLink = (props) => {
    console.log('PREV', props)
    let previousID = prevID(props.ids, props.id);
    console.log('PREVIOUS ID=', previousID)
    if (previousID === null) {
        return null;
    } else {
        return <Link to={'/edit/photo/' + previousID + '/set/' + props.set_id} >Previous</Link>
    }
}

const NextPhotoLink = (props) => {
    let theNextID = nextID(props.ids, props.id);
    console.log('NEXT ID=', nextID)
    if (theNextID === null) {
        return null;
    } else {
        return <Link to={'/edit/photo/' + theNextID + '/set/' + props.set_id} >Next</Link>
    }
}


const getFlickrPhotoIDs = (set_id) => {
    console.log('Getting photo ids......')
    const { loading, error, data } = useQuery(GET_FLICKR_SET_PHOTO_IDS, {
        variables: { id: parseInt(set_id,10) },
    });


    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error :(</p>;


    // @todo map instead of noddy code

    var ids=[];
    var flickrPHotoObjs = data.flickr_set.flickrPhotos;
    for(let i=0; i< flickrPHotoObjs.length; i++) {
        ids.push(flickrPHotoObjs[i].id);
    }

    console.log('IDS', ids);

    return ids;
}


function handleKeyDown(event) {
    if(event.keyCode === 13) {
        console.log('Enter key pressed')
    }

    console.log('KEY DOWN', event);
}

function FlickrPhoto(props) {
    const {id,set_id} = useParams();

    let setPhotoIDS = getFlickrPhotoIDs(set_id);

    const { loading, error, data } = useQuery(GET_FLICKR_PHOTO, {
        variables: { id: parseInt(id,10) },
    });


    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error :(</p>;

    console.log('Photo Data', data);
    let photo = data.flickr_photo;


    console.log('FPHOTO - getScreen=', getScreen());


    return <div onKeyDown={handleKeyDown} className={'singlePhoto'}><Helmet><title>Photo: {photo.title}</title></Helmet>
        <PrevPhotoLink id={id} ids={setPhotoIDS} set_id={set_id}/>
        <NextPhotoLink id={id} ids={setPhotoIDS} set_id={set_id}/>
        <img src={photo.large_url} title={photo.title} />
        <FlickrPhotoForm photo={photo}/>
        <ToastContainer position={"bottom-center"}/>
    </div>;
}

export default FlickrPhoto;
