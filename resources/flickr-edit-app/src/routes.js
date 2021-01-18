import FlickrSet from "./components/FlickrSet";
import FlickrSetContainer from "../../js/components/flickr_set_container";

const React = require('react')
const {
    Router,
    Route,
    IndexRoute,
    browserHistory
} = require('react-router')
const App = require('components/app/app')
const Movies = require('components/movies/movies.js')

module.exports = (
    <Router history={browserHistory}>
        <Route path="/" component={FlickrSetContainer}>
            <IndexRoute component={FlickrSetContainer} />
            <Route path="sets" component={FlickrSet}>
                <Route path=":id" component={FlickrSet} />
            </Route>
        </Route>
    </Router>
)
