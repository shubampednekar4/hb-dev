"use strict";

import React from "react";
import {Instructions} from "./Instructions";
import {Table} from "./Table";

/**
 * Body class
 */
export class Body extends React.Component
{
    constructor(props)
    {
        super(props);
    }

    render()
    {
        switch (this.props.select) {
            case 'instructions':
                return <Instructions/>
            case 'people':
                return <Table type={this.props.select}/>
            case 'products':
                return <Table type={this.props.select}/>
            default:
                return <p>Element View Not Set</p>
        }

    }
}
