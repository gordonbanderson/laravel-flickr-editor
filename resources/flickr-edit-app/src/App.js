import React, {useState, useEffect, Fragment} from 'react';
import {ApolloClient, ApolloProvider, InMemoryCache} from '@apollo/client';
import {GRAPHQL_API} from "./constants";
import FlickrSets from "./components/FlickrSets";
import { BrowserRouter as Router, Route, Link } from "react-router-dom";
import FlickrSet from "./components/FlickrSet";
import FlickrPhoto from "./components/FlickrPhoto";
import {FLICKR_SETS_SCREEN, setScreen} from "./components/Screen";

//import FlickrSet from "./components/FlickrSet";

const client = new ApolloClient({
    uri: GRAPHQL_API,
    cache: new InMemoryCache()
});


function App() {
    setScreen(FLICKR_SETS_SCREEN);
        return (
            <ApolloProvider client={client}>
                <Router>
                    <main>
                        <Route path="/" component={FlickrSets} />
                        <Route path="/set/:id"  component={FlickrSet} />
                        <Route path="/set/:id/photo/:photo_id"  component={FlickrPhoto}  />
                    </main>
                </Router>
            </ApolloProvider>);

}



const About = ({match:{params:{id}}}) => (
    // props.match.params.name
    <Fragment>
        <h1>About {id}</h1>
        <FakeText />
    </Fragment>
);

const Contact = () => (
    <Fragment>
        <h1>Contact</h1>
        <FakeText />
    </Fragment>
);


const FakeText = () => (
    <Fragment>
        <p>Lorem ipsum blah blah</p>
    </Fragment>
);

export default App;
