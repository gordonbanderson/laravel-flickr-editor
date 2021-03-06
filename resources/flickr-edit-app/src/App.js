import React, {Fragment} from 'react';
import {ApolloClient, ApolloProvider, InMemoryCache} from '@apollo/client';
import {GRAPHQL_API} from "./constants";
import FlickrSets from "./components/FlickrSets";
import {BrowserRouter as Router, Route} from "react-router-dom";
import FlickrSet from "./components/FlickrSet";
import FlickrPhoto from "./components/FlickrPhoto";
import {FLICKR_SETS_SCREEN, setScreen} from "./components/Screen";
import HomePanel from "./components/HomePanel";
import OrphanedPanel from "./components/orphaned/OrphanedPanel";
import UnimportedPanel from "./components/unimported/UnimportedPanel";
import StatusPanel from "./components/status/StatusPanel";
import PhotosForDatePanel from "./components/orphaned/PhotosForDatePanel";
import {Provider} from 'react-redux';
import store from "./store/store";
//import FlickrSet from "./components/FlickrSet";

const client = new ApolloClient({
    uri: GRAPHQL_API,
    cache: new InMemoryCache()
});


function App() {

    setScreen(FLICKR_SETS_SCREEN);
        return (
            <ApolloProvider client={client}>
                <Provider store={store}>
                <Router>
                    <main>
                        <Route path="/">
                            <HomePanel />
                        </Route>
                        <Route path="/editor/edit/sets">
                            <FlickrSets />
                        </Route>

                        <Route path="/editor/edit/set/:id">
                            <FlickrSet />
                        </Route>

                        <Route path="/editor/edit/photo/:id/set/:set_id">
                            <FlickrPhoto />
                        </Route>

                        <Route path="/editor/import/sets">
                            <UnimportedPanel />
                        </Route>


                        <Route exact path="/editor/orphan/photos">
                            <OrphanedPanel />
                        </Route>

                        <Route path="/editor/orphan/photos/:date">
                            <PhotosForDatePanel />
                        </Route>


                        <Route path="/editor/status">
                            <StatusPanel />
                        </Route>

                    </main>
                </Router>
                </Provider>
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
