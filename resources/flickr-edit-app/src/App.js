import React, { useState, useEffect } from 'react';
import {ApolloClient, ApolloProvider, InMemoryCache} from '@apollo/client';
import {GRAPHQL_API} from "./constants";

//import FlickrSet from "./components/FlickrSet";

const client = new ApolloClient({
    uri: GRAPHQL_API,
    cache: new InMemoryCache()
});


function App() {
        return (
            <ApolloProvider client={client}>
                <div>
                    <h2>My first Apollo app 🚀</h2>
                </div>
            </ApolloProvider>);
    /*
  const [data, setData] = useState({ flickrSets: [] })


  useEffect(() => {
    const fetchData = async () => {
        console.log('In fetch data');
      const queryResult = await axios.post(
          Constants.GRAPHQL_API, {
            query: Constants.GET_FLICKR_SET_LIST
          }
      );
      const result = queryResult.data.data;
      setData({ flickrSets: result.flickr_sets });
    };

    console.log('Fetching data', Constants.GRAPHQL_API);

    fetchData();
  });

  return (
      <div>
        <h1>{Constants.TITLE}</h1>
        <ul>
          {data.flickrSets.map(item => (
              <li key={item.id}>
                <FlickrSet item={item}/>
              </li>
          ))}
        </ul>
      </div>
  );

     */
}

export default App;
