import {GRAPHQL_API} from "./constants";
import * as Constants from './constants';
import { ApolloClient, InMemoryCache } from '@apollo/client';
import { ApolloProvider } from '@apollo/client';
import App from "./App";

const React = require('react')
const { render } = require('react-dom')
//const { Provider } = require('react-redux')
//const { createStore } = require('redux')
//const reducers = require('./modules')
//const routes = require('./routes.js')

/*
module.exports = render((
    <Provider store={createStore(reducers)}>
        {routes}
    </Provider>
), document.getElementById('root'))
 */





/*
function App() {
    return (
        <ApolloProvider client={client}>
            <div>
                <h2>My first Apollo app 🚀</h2>
            </div>
        </ApolloProvider>
    );
}

 */

render(<App />, document.getElementById('root'));