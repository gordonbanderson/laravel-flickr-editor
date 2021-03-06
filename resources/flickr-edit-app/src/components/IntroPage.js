import React from 'react';
import {HOME_TAB} from "./HomePanel";


function IntroPage(props)  {
    //const {selectedTab, children} = props;
    let selectedTab = 'WIBBLE';
    if (selectedTab === HOME_TAB) {
        return <div>
            <h1 className={"pt-4"}>Welcome to Flickr Editor!</h1>
            Intro blurb

        </div>
            ;
    } else {
        return null;
    }
}

export default IntroPage;
