import React, {useState} from 'react';
import {Link} from "react-router-dom";
import {Helmet} from 'react-helmet';
import IntroPage from "./IntroPage";

export const HOME_TAB='Home';
export const EDIT_IMPORTED_TAB='Edit Imported Sets';
export const IMPORT_UNIMPORTED_TAB='Import Unimported Sets';
export const ORPHAN_TAB='Organise Orphan Photos';
export const STATUS_TAB='Status';


const Tab = props => {
    const {selectedTab, setSelectedTab} = props;
    console.log('Tab props', props);
    return <button className={"tab" + (props.name === selectedTab ? ' active' : '')} onClick={() => {setSelectedTab(props.name);}}>
        <Link to={props.link}>{props.name}</Link>
    </button>;
}

function HomePanel(props)  {
    // @todo get the relevant tab from the route
    const [selectedTab, setSelectedTab] = useState(HOME_TAB);
    const tabSharedProps = { selectedTab, setSelectedTab };

    return <div>
        <Helmet><title>Flickr Editor</title></Helmet>
            <nav className={'flex flex-row sm:flex-row'}>
                <Tab name={HOME_TAB} link="/editor" {...tabSharedProps} />
                <Tab name={EDIT_IMPORTED_TAB} link="/editor/edit/sets" {...tabSharedProps}/>
                <Tab name={IMPORT_UNIMPORTED_TAB} link="/editor/import/sets" {...tabSharedProps}/>
                <Tab name={ORPHAN_TAB} link="/editor/orphan/photos" {...tabSharedProps}/>
                <Tab name={STATUS_TAB} link="/editor/status" {...tabSharedProps}/>
            </nav>
            <IntroPage selectedTab={selectedTab}/>
        </div>
    ;
}

export default HomePanel;
