import React from "react";
import PropTypes from 'prop-types';

class Car extends React.Component {
    render() {
        return <h2>I am a {this.props.color} Car!</h2>;
    }
}

Car.propTypes = {
    color: PropTypes.string
};

export default Car;