import gql from 'graphql-tag';


export const GRAPHQL_API = 'http://localhost/graphql';

export const TITLE = "Flickr Set List";

export const GET_FLICKR_SET_LIST = gql`
 {
  flickr_sets {
    id
    title
    description
    created_at
    updated_at
  }
}`;

export const GET_FLICKR_PHOTO = gql`
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
`;


export const GET_FLICKR_SET_PHOTOS = gql`
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
`;

export const GET_FLICKR_SET_PHOTO_IDS = gql`
    query FlickrSet($id: Int!) {
        flickr_set(id: $id) {
            id
            flickrPhotos {
                id
            }
        }
    }
`;