"use strict";

import React from "react";
import {NavButton} from "./NavButton";

/**
 * Navigation class
 */
export class Navigation extends React.Component
{
    constructor(props)
    {
        super(props);
        this.state = {
            selectedTab: this.props.selected,
        }
        this.handleClick = this.handleClick.bind(this);
    }

    handleClick = id => {
        if (id !== this.state.selectedTab) {
            this.setState({selectedTab: id});
            this.props.onSelection(id);
        }
    }

    render()
    {
        const navElements = [{
            text: 'Instructions',
            key: 'instructions'
        }, {
            text: 'State Owners/Operators',
            key: 'people'
        }, {
            text: 'Products',
            key: 'products'
        }];
        return (
            <>
                {navElements.map((element, index) => {
                    return (
                        <NavButton
                            key={element.key}
                            select={this.state.selectedTab}
                            label={element.key}
                            text={element.text}
                            handleClick={() => this.handleClick(element.key)}
                        />
                    )
                })}
            </>
        )
    }
}
