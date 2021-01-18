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
