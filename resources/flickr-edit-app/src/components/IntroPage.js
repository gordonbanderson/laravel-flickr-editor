import React, {useState} from 'react';
import {Link} from "react-router-dom";
import {Helmet} from 'react-helmet';
import {HOME_TAB} from "./HomePanel";



function IntroPage(props)  {
    const {selectedTab, children} = props;
    if (selectedTab === HOME_TAB) {
        return <div>
            <h1 className={"pt-4"}>Welcome to Flickr Editor!</h1>
            Intro blurb

            ST={selectedTab}
        </div>
            ;
    } else {
        return null;
    }
}

export default IntroPage;
