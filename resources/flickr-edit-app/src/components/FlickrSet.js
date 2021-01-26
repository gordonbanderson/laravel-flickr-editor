import React from 'react';
import {useQuery} from "@apollo/client";
import gql from 'graphql-tag';
import {Link} from "react-router-dom";
import { Helmet } from 'react-helmet';
import {FLICKR_PHOTO_SCREEN, FLICKR_SET_SCREEN, FLICKR_SETS_SCREEN, getScreen, setScreen} from "./Screen";
import  { useParams } from "react-router";

function FlickrSet() {
    const {id} = useParams();


    console.log('FS ID', id);

    /*
    query ($limit: Int!) {
          flickr_set(limit: $limit) {
            id
            title
          }
        }
     */
    const { loading, error, data } = useQuery(gql`
        query FlickrSet($id: Int!) {
              flickr_set(id: $id) {
                id
                title
                description
                flickrPhotos {
                  title
                  description
                  small_url
                  small_width
                  small_height
                  id
                }
              }
            }
    `, {
        variables: { id: parseInt(id,10) },
    });


    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error :(</p>;

    console.log('Data', data.flickr_set);

    /*
    render() {
    return (<div>
    {this.state.people.map((person, index) => (
        <p>Hello, {person.name} from {person.country}!</p>
    ))}
    </div>);
}
     */

    let photos=data.flickr_set.flickrPhotos;

    console.log('FSET - getScreen=', getScreen());

     return  (<div>
        <Helmet><title>Set: {data.flickr_set.title}</title></Helmet>
        <div className = "grid grid-cols-1 md:grid-cols-6" >
        {photos.map(({ title, id, small_url, small_height }) => (
            <div className={"setPhoto"} key={id.toString()}>
                <Link to={'/photo/'+id + `/set/`+data.flickr_set.id} onClick={setScreen(FLICKR_PHOTO_SCREEN)}><img src={small_url} title={title}/></Link>
            </div>
        ))}
    </div></div>)

     ;
}

export default FlickrSet;
