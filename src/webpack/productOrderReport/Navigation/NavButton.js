"use strict";

import React from "react";

/**
 * Nav button class
 */
export class NavButton extends React.Component
{
    constructor(props)
    {
        super(props);

        this.state = {selected: props.select};
    }

    render()
    {
        return <button
            className={`btn btn-sm btn-round ${this.props.select === this.props.label ? 'btn-primary' : 'btn-link'}`}
            onClick={this.props.handleClick}
        >
            {this.props.text}
        </button>
    }
}
