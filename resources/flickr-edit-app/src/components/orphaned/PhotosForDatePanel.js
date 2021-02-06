import React from 'react';
import {useParams} from "react-router";

function PhotosForDatePanel(props)  {
    const {date} = useParams();
    /*
    const { loading, error, data } = useQuery(GET_AMOUNT_OF_ORPHAN_PHOTOS_BY_DAY);

    if (loading) return <p>Loading...</p>;
    if (error) return <p>Error :(</p>;

    console.log(data);
*/
    console.log(date);
    return <div>Photos for Date {date}</div>

}

export default PhotosForDatePanel;
