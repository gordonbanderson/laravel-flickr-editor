const React = require('react')
const {
  Router,
  Route,
  IndexRoute,
  browserHistory
} = require('react-router')
const App = require('www/package/resources/flickr-edit-app/redux-netflix/src/components/app/app')
const Movies = require('www/package/resources/flickr-edit-app/redux-netflix/src/components/movies/movies.js')
const Movie = require('www/package/resources/flickr-edit-app/redux-netflix/src/components/movie/movie.js')

module.exports = (
  <Router history={browserHistory}>
    <Route path="/" component={App}>
      <IndexRoute component={Movies} />
      <Route path="movies" component={Movies}>
        <Route path=":id" component={Movie} />
      </Route>
    </Route>
  </Router>
)
