import React from 'react';

function FlickrSet(props) {
    return (
        <div>
            <a href={props.item.url}
               rel="noopener noreferrer"
               target="_blank">{props.item.title}</a>
             {props.item.title}
        </div>
    );
}

export default FlickrSet;
