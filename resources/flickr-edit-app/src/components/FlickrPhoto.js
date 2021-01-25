import React, {useState} from 'react';
import {useQuery, useMutation} from "@apollo/client";
import gql from 'graphql-tag';
import {Link} from "react-router-dom";
import {Helmet} from "react-helmet";

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

    const [titleInput, setTitleInput] = useState(photo.title);
    const [descriptionInput, setDescriptionInput] = useState(photo.description);

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


export function FlickrPhotoFormNOT(props) {
    let photo = props.photo;
    console.log('Form', props);

    let input;
    const [updatePhoto, { data }] = useMutation(UPDATE_PHOTO);


    const handleSubmit = (e) => {
        e.preventDefault();
        updatePhoto({ variables: { id: input.value, title: input.value, description: input.value } });
    };
    

    /*
    <form className="formInput" onSubmit={(e) => {
          e.preventDefault();
         addTodo({variables: {todo: todoInput, isPublic }});
        }}>
          <input
            className="input"
            placeholder="What needs to be done?"
            value={todoInput}
            onChange={e => (setTodoInput(e.target.value))}
          />
          <i className="inputMarker fa fa-angle-right" />
        </form>
     */

    return (<form onSubmit={handleSubmit} className={"form p-10"}>
        <div>
            <input
                className="input"
                placeholder="What needs to be done?"
                value={todoInput}
                onChange={e => (setTodoInput(e.target.value))}
            />
            <label htmlFor="title">Title</label>
            <input
                type="text"
                id="title"
                name="title"
                defaultValue={photo.title}
            />
        </div>
        <div>
            <label htmlFor="description">Description</label>
            <textarea
                id="description"
                name="description"
                defaultValue={photo.description}
            />
        </div>
        <button className={"border rounded my-6 p-3"}>Save</button>
    </form>
);

}

function FlickrPhoto(props) {
    let id = props.match.params.photo_id;

    const { loading, error, data } = useQuery(gql`
        query FlickrPhoto($id: Int!) {
              flickr_photo(id: $id) {
                id
                 title
                  description
                  small_url
                  small_width
                  small_height
                  large_url
                  large_width
                  large_height
              }
            }
    `, {
        variables: { id: parseInt(id,10) },
    });


    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error :(</p>;

    console.log('Photo Data', data);
    let photo = data.flickr_photo;

    return <div><Helmet><title>Photo: {photo.title}</title></Helmet>
        <img src={photo.large_url} title={photo.title}/>
        <FlickrPhotoForm photo={photo}/>
    </div>;
}

export default FlickrPhoto;
