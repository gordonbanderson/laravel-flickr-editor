import gql from 'graphql-tag';


export const GRAPHQL_API = 'http://localhost/graphql';

export const TITLE = "Flickr Set List";

export const GET_IMPORTED_FLICKR_SET_LIST = gql`
 {
  imported_flickr_sets {
    id
    title
    description
    created_at
    updated_at,
    imported
  }
}`;

export const GET_UNIMPORTED_FLICKR_SET_LIST = gql`
 {
  unimported_flickr_sets {
    id
    title
    description
    created_at
    updated_at,
    imported
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
                id
                title
                description
                small_url
                small_width
                small_height
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

export const GET_AMOUNT_OF_ORPHAN_PHOTOS_BY_DAY = gql `
    {
        number_of_orphaned_photos_by_date {
            amount_of_photos
            date_of_photos
        }
    }`;

export const GET_ORPHANED_PHOTOS_BY_DAY =gql`
    query PhotosByDate($date: String!) {
        photos_by_date(date:$date) {
            id
            title
            description
            small_url
            small_width
            small_height
        }
    }	
`;

export const CREATE_FLICKR_SET = gql`
    mutation CreateFlickrSet($title: String!, $description: String!) {
        createFlickrSet(title: $title, description: $description) {
            id
            title
            description
        }
    }`;


export const ADD_PHOTOS_TO_FLICKR_SET = gql`
    mutation AddPhotosToFlickrSet($id: Int!, $photo_ids: [Int!]) {
        addPhotosToFlickrSet(id: $id, photo_ids: $photo_ids) {
            id
            title
            description
            flickrPhotos {
                id
                title
                description
                small_url
                small_width
                small_height
            }
        }
    }`;

/*
gql`

    mutation CreateFlickrSet($title: String!, $description: String!) {
        createFlickrSet(title: title: $title, description: $description) {
            id
            title
            description
        }
    }`;
    */