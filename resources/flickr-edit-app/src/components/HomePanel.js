import React, {useState} from 'react';
import {Link} from "react-router-dom";
import {Helmet} from 'react-helmet';
import IntroPage from "./IntroPage";
export const HOME_TAB='Home';
const EDIT_IMPORTED_TAB='Edit Imported Sets';
const IMPORT_UNIMPORTED_TAB='Import Unimported Sets';
const ORPHAN_TAB='Organise Orphan Photos';
const STATUS_TAB='Status';

const Tab = props => {
    const {selectedTab, setSelectedTab, children} = props;
    console.log('Tab props', props);
    return <button className={"tab" + (props.name === selectedTab ? ' active' : '')} onClick={() => {setSelectedTab(props.name);}}>
        <Link to={props.link}>{props.name}</Link>
    </button>;
}

function HomePanel(props)  {
    // @todo get the relevant tab from the route
    const [selectedTab, setSelectedTab] = useState(HOME_TAB);

    return <div>
        <Helmet><title>Flickr Editor</title></Helmet>
            <nav className={'flex flex-row sm:flex-row'}>
                <Tab name={HOME_TAB} link={"/editor"} setSelectedTab={setSelectedTab} selectedTab={selectedTab} />
                <Tab name={EDIT_IMPORTED_TAB} link={"/editor/edit/sets"} setSelectedTab={setSelectedTab}  selectedTab={selectedTab}/>
                <Tab name={IMPORT_UNIMPORTED_TAB} link={"/editor/import/sets"} setSelectedTab={setSelectedTab}  selectedTab={selectedTab}/>
                <Tab name={ORPHAN_TAB} link={"/editor/orphan/photos"} setSelectedTab={setSelectedTab}  selectedTab={selectedTab}/>
                <Tab name={STATUS_TAB} link={"/editor/status"} setSelectedTab={setSelectedTab}  selectedTab={selectedTab}/>
            </nav>
            <IntroPage selectedTab={selectedTab}/>
        </div>
    ;
}

export default HomePanel;
