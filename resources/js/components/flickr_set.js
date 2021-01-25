import React from "react";
import PropTypes from 'prop-types';

class FlickrSet extends React.Component {
    render() {
        return <h2>I am a {this.props.color} Car!</h2>;
    }
}

FlickrSet.propTypes = {
    flickr_id: PropTypes.string,
    title: PropTypes.string,
    description: PropTypes.string
};

export default FlickrSet;