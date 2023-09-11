"use strict";

import React from "react";
import * as ReactDOM from "react-dom";
import {Navigation} from "./productOrderReport/Navigation/Navigation";
import {Body} from "./productOrderReport/Body/Body";

/**
 * Product Order Report class
 */
class ProductOrderReport extends React.Component
{
    constructor(props)
    {
        super(props);

        this.state = {
            selected: 'instructions'
        }
        this.handleSelection = this.handleSelection.bind(this);
    }

    handleSelection = (id) => {
        this.setState(prevState => {
            if (prevState.selected !== id) {
                return {selected: id}
            }
        });
    }

    render = () => {
        return (
            <>
                <div className="row mt-4">
                    <div className={"col-xl-2 col-lg-12"}>
                        <p className="lead">Products & Orders Report:</p>
                    </div>
                    <div className={"col-xl-10 col-lg-12"}>
                        <Navigation
                            selected={this.state.selected}
                            onSelection={this.handleSelection}/>
                    </div>
                </div>
                <div className="row">
                    <div className="col-12">
                        <Body select={this.state.selected}/>
                    </div>
                </div>
            </>
        )
    }
}

ReactDOM.render(<ProductOrderReport/>, document.getElementById('report'));
