import React, {useEffect, useState} from 'react';
import {useMutation, useQuery} from "@apollo/client";
import gql from 'graphql-tag';
import {Link} from "react-router-dom";
import {Helmet} from "react-helmet";
import {FLICKR_PHOTO_SCREEN, getScreen, setScreen} from "./Screen";
import {useParams} from "react-router";
import {GET_FLICKR_PHOTO, GET_FLICKR_SET_PHOTO_IDS} from "../constants";
import {toast, ToastContainer} from 'react-toastify';
import {useHistory} from "react-router-dom";
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


// see https://stackoverflow.com/questions/42036865/react-how-to-navigate-through-list-by-arrow-keys
// @todo Separate this for other components to use
const useKeyPress = function(targetKey) {
    const [keyPressed, setKeyPressed] = useState(false);

    function downHandler({ key }) {
        console.log('DOWN' ,key);
        if (key === targetKey) {
            setKeyPressed(true);
        }
    }

    const upHandler = ({ key }) => {
        console.log('UP' ,key);

        if (key === targetKey) {
            setKeyPressed(false);
        }
    };

    React.useEffect(() => {
        window.addEventListener("keydown", downHandler);
        window.addEventListener("keyup", upHandler);

        return () => {
            window.removeEventListener("keydown", downHandler);
            window.removeEventListener("keyup", upHandler);
        };
    }, []); // see https://stackoverflow.com/questions/59546928/keydown-up-events-with-react-hooks-not-working-properly

    return keyPressed;
};

const FlickrPhotoForm = (props) => {
    console.log('------------------------------- new form ------------------------------');
    console.log('++++ Flickr photo form', props);
    const [leftKeyPressCount, setLeftKeyPressCount] = useState(0);
    const [rightKeyPressCount, setRightKeyPressCount] = useState(0);

    let history = useHistory();
    let photo = props.photo;

    setScreen(FLICKR_PHOTO_SCREEN);

    const [titleInput, setTitleInput] = useState(photo.title);
    const [descriptionInput, setDescriptionInput] = useState(photo.description);
    const leftPress = useKeyPress("ArrowLeft");
    const rightPress = useKeyPress("ArrowRight");


    useEffect(() => {
        console.log('+++++ Use effect of left press', props);
        let ids = props.photoIDS;
        let index= ids.indexOf(photo.id);
        let prevID = index > 0 ? ids[index-1] : null;

        console.log('PREV ID', prevID);
        console.log('COUNT (left, right)', leftKeyPressCount, rightKeyPressCount);

        // 1) Ignore key presses other than the first one.   Note that this function is called prior to key being
        // pressed, as such need to check the keyPressCount state
        // 2) If nextID is not defined we are at the last image
        if (leftKeyPressCount >= 1 && prevID !== null && prevID !== undefined) {
            let url='/editor/edit/photo/' + prevID + '/set/'  + props.setID;
            console.log('PREV URL', url);
            history.push(url);
        } else {
            setRightKeyPressCount(0);
        }

        setLeftKeyPressCount(leftKeyPressCount+1);


    }, [leftPress]);

    useEffect(() => {
        let ids = props.photoIDS;
        let index= ids.indexOf(photo.id);
        let nextID = index < ids.length-1 ? ids[index+1] : null;
        console.log('COUNT (left, right)', leftKeyPressCount, rightKeyPressCount);

        // 1) Ignore key presses other than the first one.   Note that this function is called prior to key being
        // pressed, as such need to check the keyPressCount state
        // 2) If nextID is not defined we are at the last image
        if (rightKeyPressCount >= 1 && nextID !== null && nextID !== undefined) {
            let url='/editor/edit/photo/' + nextID + '/set/'  + props.setID;
            console.log('NEXT URL', url);
            history.push(url);
        } else {
            setLeftKeyPressCount(0);
        }

        setRightKeyPressCount(rightKeyPressCount+1);


    }, [rightPress]);


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
        return <Link to={'/editor/edit/photo/' + previousID + '/set/' + props.set_id} >Previous</Link>
    }
}

const NextPhotoLink = (props) => {
    let theNextID = nextID(props.ids, props.id);
    console.log('NEXT ID=', theNextID)
    if (theNextID === null) {
        return null;
    } else {
        return <Link to={'/editor/edit/photo/' + theNextID + '/set/' + props.set_id} >Next</Link>
    }
}


const getFlickrPhotoIDs = (set_id) => {
    const { loading, error, data } = useQuery(GET_FLICKR_SET_PHOTO_IDS, {
        variables: { id: parseInt(set_id,10) },
    });

    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error :(</p>;

    var flickrPHotoObjs = data.flickr_set.flickrPhotos;
    const ids = flickrPHotoObjs.map(photo => Number(photo.id));

    return ids;
}


function handleKeyDown(e) {
    console.log('KEY:', e.key)
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
        <FlickrPhotoForm photo={photo} photoIDS={setPhotoIDS} setID={set_id}/>
        <ToastContainer position={"bottom-center"}/>
    </div>;
}

export default FlickrPhoto;
