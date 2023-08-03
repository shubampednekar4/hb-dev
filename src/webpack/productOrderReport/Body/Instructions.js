"use strict";

import React from "react";
import {FormattedMessage} from "react-intl";

/**
 * Body content class
 */
export class Instructions extends React.Component
{
    constructor(props)
    {
        super(props);
    }

    render()
    {
        return (
            <div className="row justify-content-center">
                <div className="col-xl-4 col-lg-6 col-md-8 col-sm-12">
                    <div className="card bg-primary">
                        <div className="card-header">
                            <h3 className="card-title">Products & Orders Report Instructions</h3>
                        </div>
                        <div className="card-body">
                            <p>
                                These reports will help you answer questions like how many operators are ordering
                                cleaner, which operators are buying the most, and many other questions. The first step
                                is to decide is if you are asking a question about people or products. For example,
                                "How many operators are ordering cleaner" is primarily about the cleaner. So you would
                                want to list by products. By contrast, if you are asking "What products Operators are
                                ordering" then you would want to list by person.
                            </p>
                            <p>
                                Next you need to specify the timeframe. The default timeframe is within the current
                                month. You can set any time frame. As a reminder, the assumption is midnight to
                                midnight. This means that 1 Jan 2021 to 2 Jan 2021 will be looking from the start of
                                the day on the first to end of the day on the second.
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        )
    }
}
