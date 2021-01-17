// Flickr editor

// needed for the browser to work
import React from "react";
import ReactDOM from 'react-dom';

import ShoppingListRender from "./components/shoppinglist";
import Car from "./components/car";

window.addEventListener('load', function() {
    console.log('All assets are loaded')
    // - Code to execute when all DOM content is loaded.
    // - including fonts, images, etc.

    alert('test');
    console.log('Rendering components');
//ReactDOM.render(<ShoppingListRender/>, document.getElementById('flickrEditor'));
ReactDOM.render(<Car color="red"/>, document.getElementById('root'));

    var el = document.getElementById('root');
    console.log('ELEMENT', el);
    el.innerText = (' ************* from js');
});

