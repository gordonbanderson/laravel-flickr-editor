import React, { useState, useEffect } from 'react';
import axios from 'axios';
import * as Constants from './constants';
import FlickrSet from "./components/FlickrSet";


function App() {
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
}

export default App;
