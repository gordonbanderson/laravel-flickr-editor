import React, { useState, useEffect } from 'react';
import axios from 'axios';
import * as Constants from './constants';
import Video from './components/Video'

function App() {
    const [data, setData] = useState({ videos: [] });

    useEffect(() => {
        const fetchData = async () => {
            const queryResult = await axios.post(
                Constants.GRAPHQL_API, {
                    query: Constants.GET_FLICKR_SET_LIST
                }
            );
            const result = queryResult.data.data;
            console.log(result);
            setData({ videos: result.videos });
        };

        fetchData();
    });

    return (
        <div>
            <h1>{Constants.TITLE}</h1>
            <ul>
                {data.videos.map(item => (
                    <li key={item.id}>
                        <Video item={item}/>
                    </li>
                ))}
            </ul>
        </div>
    );
}

export default App;
