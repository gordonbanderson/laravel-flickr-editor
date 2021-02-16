import React, {useState} from 'react';
import {Link} from "react-router-dom";
import {Helmet} from 'react-helmet';
import {FLICKR_ORPHANED_PHOTOS, FLICKR_SETS_SCREEN, FLICKR_UNIMPORTED_SETS_SCREEN, setScreen} from "./Screen";

function HomePanel(props)  {
    const [selectedTab, setSelectedTab] = useState(1);

    return <div>
        <Helmet><title>Flickr Editor</title></Helmet>
        <nav className={'flex flex-row sm:flex-row'}>
            <button className="tab active">
                <Link to={'/'} onClick={setScreen(FLICKR_SETS_SCREEN)}>Intro</Link>
            </button>
            <button className="tab">
                <Link to={'/editor/edit/sets'} onClick={setScreen(FLICKR_SETS_SCREEN)}>Edit Imported Sets</Link>
            </button>
                <button className="tab">
                    <Link to={'/editor/import/sets'} onClick={setScreen(FLICKR_UNIMPORTED_SETS_SCREEN)}>Import Unimported Sets</Link>
                </button>
                <button className="tab">
                    <Link to={'/editor/orphan/photos'} onClick={setScreen(FLICKR_ORPHANED_PHOTOS)}>Organise Orphan Photos</Link>
                </button>
                <button className="tab">
                    <Link to={'/editor/status'} onClick={setScreen(FLICKR_ORPHANED_PHOTOS)}>Status</Link>
                </button>
            </nav>

        <h1 className={"pt-4"}>Intro Screen</h1>
        </div>
    ;
}

export default HomePanel;
