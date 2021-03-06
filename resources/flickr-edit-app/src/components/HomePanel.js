import React from 'react';
import {Link} from "react-router-dom";
import {Helmet} from 'react-helmet';
import IntroPage from "./IntroPage";
import {useDispatch, useSelector} from "react-redux";
import {selectTab} from "../store/slices/tabSlice";
import {EDIT_IMPORTED_TAB, HOME_TAB, IMPORT_UNIMPORTED_TAB, ORPHAN_TAB, STATUS_TAB} from "./constants/tabs";


// see https://dev.to/nazmifeeroz/using-usecontext-and-usestate-hooks-as-a-store-mnm
// this looks cleaner https://blog.logrocket.com/use-hooks-and-context-not-react-and-redux/
// this is better https://redux-toolkit.js.org/tutorials/quick-start#full-counter-app-example

const Tab = props => {
    const selectedTab = useSelector(state => state.mainTab.value)
    const dispatch = useDispatch();

    console.log('Tab props', props);
    return <button className={"tab" + (props.name === selectedTab ? ' active' : '')} onClick={() => {
        dispatch(selectTab(props.name));}}>
        <Link to={props.link}>{props.name}</Link>
    </button>;
}

const Tabs = props => {
    return  <nav className={'flex flex-row sm:flex-row'}>
        <Tab name={HOME_TAB} link="/editor"  />
        <Tab name={EDIT_IMPORTED_TAB} link="/editor/edit/sets" />
        <Tab name={IMPORT_UNIMPORTED_TAB} link="/editor/import/sets" />
        <Tab name={ORPHAN_TAB} link="/editor/orphan/photos" />
        <Tab name={STATUS_TAB} link="/editor/status" />
    </nav>;
}

function HomePanel(props)  {

    return <div>
        <Helmet><title>Flickr Editor</title></Helmet>
           <Tabs/>
            <IntroPage />
        </div>
    ;
}

export default HomePanel;
