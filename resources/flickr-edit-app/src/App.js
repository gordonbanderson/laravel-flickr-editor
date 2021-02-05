import React, {useState, useEffect, Fragment} from 'react';
import {ApolloClient, ApolloProvider, InMemoryCache} from '@apollo/client';
import {GRAPHQL_API} from "./constants";
import FlickrSets from "./components/FlickrSets";
import { BrowserRouter as Router, Route, Link } from "react-router-dom";
import FlickrSet from "./components/FlickrSet";
import FlickrPhoto from "./components/FlickrPhoto";
import {FLICKR_SETS_SCREEN, setScreen} from "./components/Screen";
import HomePanel from "./components/HomePanel";
import OrphanedPanel from "./components/orphaned/OrphanedPanel";
import UnimportedPanel from "./components/unimported/UnimportedPanel";
import StatusPanel from "./components/status/StatusPanel";

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
                        <Route path="/">
                            <HomePanel />
                        </Route>

                        <Route path="/edit/sets">
                            <FlickrSets />
                        </Route>

                        <Route path="/edit/set/:id">
                            <FlickrSet />
                        </Route>

                        <Route path="/edit/photo/:id/set/:set_id">
                            <FlickrPhoto />
                        </Route>

                        <Route path="/import/sets">
                            <UnimportedPanel />
                        </Route>

                        <Route path="/orphan/photos">
                            <OrphanedPanel />
                        </Route>

                        <Route path="/status">
                            <StatusPanel />
                        </Route>

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
